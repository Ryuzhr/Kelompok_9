<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Ubah ini untuk menggunakan model Produk
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('user.login')->with('error', 'You do not have access to this page.');
        }
        return view('owner.dashboardowner');
    }
    

    public function viewkelolauser()
    {
        $users = User::where('role', '!=', 'owner')->get();
        return view('owner.kelolauser', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Cek jika role pengguna adalah 'owner'
        if ($user->role === 'owner') {
            return redirect()->back()->with('error', 'Role pengguna ini tidak dapat diubah.');
        }
    
        // Validasi input role (opsional)
        $request->validate([
            'role' => 'required|in:admin,customer', // Pastikan role hanya bisa 'admin' atau 'customer'
        ]);
    
        // Update role pengguna
        $user->role = $request->input('role');
        $user->save();
    
        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    
    // Fungsi untuk laporan stok produk
    public function laporanStok()
    {
        // Ambil semua produk
        $produks = Produk::all(); // Gunakan model Produk di sini
        return view('owner.laporan_stok', compact('produks')); // Kirim data ke view
    }
}
