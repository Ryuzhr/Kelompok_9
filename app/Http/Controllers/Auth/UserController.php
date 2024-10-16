<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.user_register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Register the user with default role 'customer'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'customer',  // Default role for new user
        ]);
    
        return redirect()->route('user.login')->with('success', 'Registration successful. Please login.');
    }    

    public function showLoginForm()
    {
        return view('auth.user_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();
    
            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard'); // Redirect to admin dashboard
            } elseif ($user->role === 'owner') {
                return redirect()->route('owner.dashboard'); // Redirect to owner dashboard
            } else {
                return redirect()->route('home'); // Redirect to customer home page
            }
        }
    
        return redirect()->back()->with('failed', 'Password atau Email Salah');
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');

    }
}
