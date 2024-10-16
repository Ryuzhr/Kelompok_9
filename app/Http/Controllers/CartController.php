<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    private function getCartCount()
    {
        $user = Auth::user();
        return Cart::where('user_id', $user ? $user->id : null)->sum('quantity');
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Temukan produk berdasarkan ID
        $product = Produk::find($productId);

        // Jika produk tidak ditemukan, kembalikan error 404
        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        // Validasi stok produk
        if ($quantity > $product->stok) {
            return response()->json(['error' => 'Stok produk tidak mencukupi'], 422);
        }

        $user = Auth::user();

        // Tambahkan item ke keranjang atau perbarui jumlah item jika sudah ada
        $cartItem = Cart::where('user_id', $user ? $user->id : null)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // Jika item sudah ada di keranjang, tambahkan jumlahnya
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Jika item belum ada di keranjang, buat item baru
            Cart::create([
                'user_id' => $user ? $user->id : null,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        // Hitung total jumlah item di keranjang
        $cartCount = $this->getCartCount();

        // Kembalikan respons sukses dan jumlah item di keranjang
        return response()->json(['success' => 'Produk berhasil ditambahkan ke keranjang', 'cartCount' => $cartCount]);
    }

    public function index()
    {
        $user = Auth::user();
        
        // Ambil item keranjang belanja pengguna yang sedang login
        $cartItems = Cart::where('user_id', $user ? $user->id : null)
                        ->with('product') // Mengambil relasi produk
                        ->get();
    
        // Hitung jumlah item di keranjang
        $cartCount = $this->getCartCount();
    
        return view('cart.index', compact('cartItems', 'cartCount')); // Kirim variabel ke tampilan
    }
    

    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        
        $cartCount = $this->getCartCount(); // Hitung jumlah item di keranjang setelah penghapusan
        
        return redirect()->route('cart.index')->with(['success' => 'Produk berhasil dihapus dari keranjang.', 'cartCount' => $cartCount]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $quantity = max($request->input('quantity'), 1);
    
        $product = Produk::findOrFail($cartItem->product_id);
        if ($quantity > $product->stok) {
            return redirect()->route('cart.index')->with('error', 'Stok produk tidak mencukupi.');
        }
        
        $cartItem->quantity = $quantity;
        $cartItem->save();

        $cartCount = $this->getCartCount(); // Hitung jumlah item di keranjang setelah pembaruan
        
        return redirect()->route('cart.index')->with(['success' => 'Jumlah barang di keranjang diperbarui', 'cartCount' => $cartCount]);
    }

    public function checkout()
    {
        // Ambil data keranjang belanja pengguna yang sedang login
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Validasi stok sebelum checkout
        foreach ($cartItems as $cartItem) {
            $product = Produk::findOrFail($cartItem->product_id);
            if ($cartItem->quantity > $product->stok) {
                return redirect()->back()->with('error', 'Stok produk ' . $product->nama . ' tidak mencukupi');
            }
        }
        
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Hitung total harga pembayaran
            $totalPrice = 0;
            foreach ($cartItems as $cartItem) {
                $totalPrice += $cartItem->quantity * $cartItem->product->harga;
            }

            // Mendapatkan alamat pengiriman dari data pengguna yang sedang login
            $alamatPengiriman = auth()->user()->address;

            // Buat pesanan
            $order = new Order();
            $order->user_id = auth()->id();
            $order->total_price = $totalPrice; // Simpan total harga
            $order->alamat_pengiriman = $alamatPengiriman; // Simpan alamat pengiriman
            $order->order_status_id = 1; // Atur status order default
            $order->save();

            // Tambahkan item pesanan
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->harga; // Tambahkan harga produk
                $orderItem->save();

                // Kurangi stok produk
                $product = Produk::findOrFail($cartItem->product_id);
                $product->stok -= $cartItem->quantity;
                $product->save();
            }

            // Hapus semua item di keranjang setelah checkout
            Cart::where('user_id', auth()->id())->delete();

            // Commit transaksi database
            DB::commit();

            // Hitung jumlah item di keranjang setelah checkout
            $cartCount = $this->getCartCount();

            // Redirect atau tampilkan pesan sukses kepada pengguna
            return redirect()->route('order.index')->with(['success' => 'Pesanan berhasil diproses.', 'cartCount' => $cartCount]);
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            // Redirect atau tampilkan pesan kesalahan kepada pengguna
            return redirect()->back()->with('error', '! Harap login terlebih dahulu !');
        }
    }
    
}