<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function show()
    {
        // Memeriksa apakah pengguna telah terautentikasi
        if (Auth::check()) {
            $user = Auth::user();
            return view('profil', compact('user'));
        } else {
            // Jika pengguna tidak terautentikasi, redirect ke halaman login atau melakukan tindakan lain sesuai kebutuhan aplikasi Anda
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Memperbarui data pengguna
        $user->name = $validatedData['name'];
        $user->address = $validatedData['address'];
        $user->telepon = $validatedData['telepon'];

        // Jika ada gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::delete('public/images/' . $user->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->storeAs('public/images', $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
