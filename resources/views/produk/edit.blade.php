@extends('layouts.maindashboard')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Produk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Produk</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Notifikasi -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama Produk</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ isset($produk) && $produk->kategori_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" name="gambar" class="form-control">
                                    @if ($produk->gambar)
                                        <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}" width="100">
                                    @else
                                        <p>Gambar tidak tersedia</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" value="{{ $produk->stok }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
