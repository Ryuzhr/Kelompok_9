<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Category;

class ProdukController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }
    public function index(Request $request)
    {
        $query = Produk::query();
    
        if ($request->has('table_search')) {
            $search = $request->input('table_search');
            $query->where('nama', 'like', "%{$search}%");
        }
    
        $produks = $query->get();
    
        return view('dataproduk', compact('produks'));
    }
    
    public function show()
    {
        $produks = Produk::get();
        return view('produk', compact('produks'));
    }

    public function showdetail($id)
    {
        $produk = Produk::findOrFail($id);
        return view('detailproduk', compact('produk'));
    }
    
    

    public function create()
    {
        $categories = Category::all();

        return view('produk.create', compact('categories'));

    }

    public function store(Request $request)
{
    // Validasi input dengan pesan error kustom
    $request->validate([
        'nama' => 'required',
        'kategori' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
        'deskripsi' => 'nullable|string',
    ], [
        'nama.required' => 'Nama produk wajib diisi.',
        'kategori.required' => 'Kategori produk wajib dipilih.',
        'gambar.required' => 'Gambar produk wajib diunggah.',
        'gambar.image' => 'File yang diunggah harus berupa gambar.',
        'gambar.mimes' => 'File gambar harus berupa salah satu dari jenis berikut: jpeg, png, jpg, gif, svg, webp.',
        'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        'harga.required' => 'Harga produk wajib diisi.',
        'harga.numeric' => 'Harga produk harus berupa angka.',
        'stok.required' => 'Stok produk wajib diisi.',
        'stok.numeric' => 'Stok produk harus berupa angka.',
    ]);

    // Proses upload gambar
    $gambar = $request->file('gambar');
    $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
    $gambar->move(public_path('images'), $nama_gambar);

    // Simpan produk
    Produk::create([
        'nama' => $request->nama,
        'kategori' => $request->kategori,
        'gambar' => '/images/'.$nama_gambar,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
    ]);

    // Redirect dan beri pesan sukses
    return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan.');
}


public function update(Request $request, $id)
{
    // Validasi input dengan pesan error kustom
    $request->validate([
        'nama' => 'required',
        'kategori' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ], [
        'nama.required' => 'Nama produk wajib diisi.',
        'kategori.required' => 'Kategori produk wajib dipilih.',
        'harga.required' => 'Harga produk wajib diisi.',
        'harga.numeric' => 'Harga produk harus berupa angka.',
        'stok.required' => 'Stok produk wajib diisi.',
        'stok.numeric' => 'Stok produk harus berupa angka.',
        'gambar.image' => 'File yang diunggah harus berupa gambar.',
        'gambar.mimes' => 'File gambar harus berupa salah satu dari jenis berikut: jpeg, png, jpg, gif, svg, webp.',
        'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
    ]);

    $produk = Produk::find($id);
    $produk->nama = $request->nama;
    $produk->kategori = $request->kategori;
    $produk->harga = $request->harga;
    $produk->stok = $request->stok;
    $produk->deskripsi = $request->deskripsi;

    if($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
        $gambar->move(public_path('images'), $nama_gambar);
        $produk->gambar = '/images/'.$nama_gambar;
    }

    $produk->save();

    return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui.');
}


    public function edit($id)
    {
    $produk = Produk::findOrFail($id);
    $categories = Category::all();
    return view('produk.edit', compact('produk', 'categories'));
    }



    public function destroy($id)
    {
        $produk = Produk::find($id);
    
        if(!$produk) {
            return redirect()->route('produks.index')->with('error', 'Produk tidak ditemukan.');
        }
    
        $produk->delete();
    
        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus.');
    }
    public function byCategory($id)
{
    $category = Category::findOrFail($id);
    $produks = Produk::where('kategori', $id)->get();

    return view('produk.byCategory', compact('produks', 'category'));
}
public function home()
{
    $produks = Produk::all();
    return view('home', compact('produks'));
}

public function search(Request $request)
{
    $query = $request->input('query');
    
    // Cari produk berdasarkan nama
    $produks = Produk::where('nama', 'LIKE', "%$query%")->get();

    // Kembalikan hasil pencarian ke view produk
    return view('produk.search_results', compact('produks'));
}


}
