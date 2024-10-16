<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
//     public function login(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         // Get the authenticated user
//         $user = Auth::user();

//         // Redirect based on user role
//         if ($user->role == 'admin') {
//             return redirect()->intended('/dashboard');
//         } elseif ($user->role == 'customer') {
//             return redirect()->intended('/home');
//         }

//         // Add additional role checks if necessary
//     }

//     // If authentication fails, redirect back with error
//     return back()->withErrors(['email' => 'Email atau kata sandi tidak valid.']);
// }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'address' => 'required',
        ], [
            'email.unique' => 'Email telah digunakan sebelumnya.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.', // Pesan kustom untuk validasi panjang minimal password
        ]);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->role = 'customer'; // Assign a default role
        $user->save();
    
        // Redirect ke halaman masuk setelah pendaftaran berhasil
        return redirect('/')->with('success', 'Akun Anda telah berhasil dibuat. Silakan masuk untuk melanjutkan.');
    }
    public function logout(Request $request)
{
    Auth::logout(); // Logout pengguna
    $request->session()->invalidate(); // Meregenerasi sesi
    $request->session()->regenerateToken(); // Membuat token baru
    return redirect('/'); // Redirect ke halaman utama setelah logout
}
public function adminLogout(Request $request)
{
    Auth::logout(); // Logout the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate the token to prevent CSRF attacks

    return redirect('/'); // Redirect to the admin login page
}

}
