<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:10', 
        'email' => 'required|string|email|max:255|unique:admins',
        'address' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $this->storeImage($image); // Panggil metode storeImage untuk menyimpan gambar
    }

    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'password' => Hash::make($request->password),
        'image' => $imagePath,
    ]);

    // Setelah berhasil menyimpan gambar, simpan path gambar ke dalam sesi
    Session::put('admin_image', $imagePath);

    return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            // Jika login berhasil, simpan path gambar di session
            Session::put('admin_image', Auth::guard('admin')->user()->image);
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('error', 'Invalid Credentials');
    }

    public function showRegisterForm()
    {
        return view('auth.admin_register');
    }

    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    private function storeImage($image)
    {
        // Generate nama unik untuk gambar
        $imageName = time().'.'.$image->getClientOriginalExtension();
        
        // Simpan gambar ke dalam folder public/admin_images
        $image->move(public_path('admin_images'), $imageName);
        
        // Path lengkap dari gambar yang disimpan
        $imagePath = 'admin_images/'.$imageName;
        
        return $imagePath;
    }
}
