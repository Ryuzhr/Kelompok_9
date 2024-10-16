@extends('layouts.mainproduk')

@section('container')
<section class="product h-100">
    <div class="container text-center mt-5 pb-2">
        <div class="title d-flex justify-content-between">
            <h3>Produk kami</h3>
        </div>
        <hr class="mt-3 mb-4">
        <div class="row">
            @foreach($produks as $produk)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="{{ asset($produk->gambar) }}" class="img-thumbnail img-fluid product-image" alt="{{ $produk->nama }}">
                        <h5 class="card-title mt-2">{{ $produk->nama }}</h5>
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
