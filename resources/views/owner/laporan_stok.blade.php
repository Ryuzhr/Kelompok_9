@extends('owner.layout.main1')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Stok Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Laporan Stok Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Tabel Laporan Stok Produk -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Laporan Stok Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Produk</th>
                      <th>Stok</th>
                      <th>Kategori</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($produks->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    @else
                        @foreach($produks as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>{{ $produk->kategori }}</td>
                            <td>{{ number_format($produk->harga, 2) }}</td>
                        </tr>
                        @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
