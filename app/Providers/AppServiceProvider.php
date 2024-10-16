<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Bagikan data kategori dan jumlah keranjang ke semua view
        View::composer('*', function ($view) {
            $categories = Category::all();

            // Jika pengguna sudah login, hitung jumlah item di keranjang mereka
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            }

            // Bagikan kategori dan jumlah keranjang ke semua view
            $view->with([
                'categories' => $categories,
                'cartCount' => $cartCount
            ]);
        });
    }
}
