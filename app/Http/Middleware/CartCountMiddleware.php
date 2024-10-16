<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartCountMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            view()->share('cartCount', $cartCount);
        }

        return $next($request);
    }
}
