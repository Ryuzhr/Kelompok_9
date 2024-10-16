@extends('layouts.maindashboard')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Produk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route ('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Data Produk</li>
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
                    <a href="{{ route('produks.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <form action="{{ route('produks.index') }}" method="get" class="input-group input-group-sm"
                                    style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Gambar</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produks as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->nama }}</td>
                                        <td>{{ $produk->kategori }}</td>
                                        <td>
                                            <img src="{{ $produk->gambar }}" alt="{{ $produk->nama }}"
                                                class="img-fluid" style="max-width: 100px;">
                                        </td>
                                        <td>Rp. {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deskripsiModal{{ $produk->id }}">
                                                Detail
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ route('produks.edit', $produk->id) }}"
                                                class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                                            
                                            <!-- Tombol yang memunculkan modal konfirmasi hapus -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $produk->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@foreach($produks as $produk)
    <!-- Modal Detail Deskripsi -->
    <div class="modal fade" id="deskripsiModal{{ $produk->id }}" tabindex="-1" role="dialog" aria-labelledby="deskripsiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deskripsiModalLabel">{{ $produk->nama }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! nl2br ($produk->deskripsi) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal{{ $produk->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus produk <strong>{{ $produk->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
