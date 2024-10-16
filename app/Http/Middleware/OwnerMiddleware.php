<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna terautentikasi
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Please log in to access this page.');
        }

        // Cek apakah pengguna adalah owner
        if (Auth::user()->role === 'owner') {
            return $next($request);
        }
        
        // Redirect jika tidak memiliki akses
        return redirect('/')->with('error', 'You do not have owner access.');
    }
}
