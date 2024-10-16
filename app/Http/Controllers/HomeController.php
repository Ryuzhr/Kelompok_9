<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function dashboard()
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('dashboard', compact('categories'));
    }
    
}
