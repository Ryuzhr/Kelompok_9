@extends('layouts.app')

@section('content')
<div class="container" style="margin-bottom: 260px;">
    <h1 class="my-4">Keranjang Belanja</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPayment = 0;
                    @endphp
                    @foreach($cartItems as $item)
                        @php
                            $subtotal = $item->product->harga * $item->quantity;
                            $totalPayment += $subtotal;
                        @endphp
                        <tr>
                            <td><img src="{{ asset($item->product->gambar) }}" alt="{{ $item->product->nama }}" width="50"></td>
                            <td>{{ $item->product->nama }}</td>
                            <td>Rp {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                        <button type="submit" class="btn btn-outline-secondary"{{ $item->quantity == 1 ? ' disabled' : '' }}><i class="bi bi-dash-circle"></i></button>
                                    </form>
                                    <span class="mx-2">{{ $item->quantity }}</span>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-plus-circle"></i></button>
                                    </form>
                                </div>
                            </td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <h5>Total Pembayaran: Rp {{ number_format($totalPayment, 0, ',', '.') }}</h5>
            <h5>Jumlah Item: {{ $cartCount }}</h5>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        </div>
    @endif
</div>
@endsection
