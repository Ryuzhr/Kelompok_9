@extends('layouts.mainhome')

@section('container')
<section class="product h-100">
    <div class="container text-center mt-5 pb-2">
        <div class="title d-flex justify-content-between">
            <h3>Produk Kami</h3>
            <span class="pt-3">
                <a href="/produk" class="text-danger text-decoration-none">Lihat Semua ></a>
            </span>
        </div>
        <hr class="mt-3 mb-4">
        <div class="row">
            @foreach($produks->take(3) as $produk) <!-- Membatasi jumlah produk yang ditampilkan hingga 3 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset($produk->gambar) }}" class="img-thumbnail img-fluid" alt="{{ $produk->nama }}" style="height: 200px; object-fit: cover;">
                        <h5 class="card-title">{{ $produk->nama }}</h5>
                        <p class="card-text">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <a href="{{ route('produks.detail', $produk->id) }}" class="btn btn-primary">Detail Produk</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    
</section>
@endsection
