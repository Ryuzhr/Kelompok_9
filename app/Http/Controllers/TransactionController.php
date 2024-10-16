<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil data transaksi yang sudah selesai atau dibatalkan
        $transactions = Order::whereHas('status', function($query) {
                $query->where('name', 'Selesai')->orWhere('name', 'Dibatalkan');
            })
            ->with(['user', 'items.product', 'status'])
            ->get();

        return view('datatransaksi', compact('transactions'));
    }
    public function riwayatTransaksi()
    {
        // Ambil semua transaksi untuk ditampilkan
        $transactions = Order::with(['user', 'items.product', 'status'])
            ->get();

        return view('riwayat_transaksi', compact('transactions'));
    }
}