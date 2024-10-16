@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Pesanan</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($orders->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Gambar Produk</th>
                        <th scope="col">Jumlah Produk</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Alamat Pengiriman</th>
                        <th scope="col">Status Pesanan</th>
                        <th scope="col">Tanggal Pesanan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    {{ $item->product->nama }}
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    <img src="{{ $item->product->gambar }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 100px;">
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    Jumlah: {{ $item->quantity }}
                                    <br>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ $order->alamat_pengiriman }}</td>
                            <td>
                                <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <p>{{ $order->status->name }}</p>
                                </form>                                
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Batal Pesanan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada pesanan yang tersedia.</p>
        @endif
    </div>
@endsection
