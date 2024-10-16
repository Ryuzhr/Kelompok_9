<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan untuk pengguna yang sedang login
        $orders = Order::where('user_id', auth()->id())->with('items')->get();
        
        // Tampilkan daftar pesanan ke dalam view order.index
        return view('order.index', compact('orders'));
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Mengembalikan stok produk
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stok += $item->quantity;
            $product->save();
        }

        // Hapus pesanan
        $order->delete();

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }    
}
