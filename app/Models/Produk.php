<?php
// app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama', 'kategori', 'gambar', 'harga','stok'];
}
