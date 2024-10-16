<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderDataController extends Controller
{
    public function index()
    {
        $orders = Order::with('status', 'items.product', 'user')->get();
        $statuses = OrderStatus::all();
        return view('datapesanan', compact('orders', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status_id = $request->status_id;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        $cancelledStatus = OrderStatus::where('name', 'Dibatalkan')->first();

        if ($cancelledStatus) {
            $order->order_status_id = $cancelledStatus->id;

            // Mengembalikan stok produk
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stok += $item->quantity;
                $product->save();
            }

            $order->save();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
        } else {
            return redirect()->back()->with('error', 'Status pembatalan tidak ditemukan');
        }
    }
}
