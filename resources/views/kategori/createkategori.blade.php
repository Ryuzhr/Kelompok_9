@extends('layouts.maindashboard')

@section('content')
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Kategori</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route ('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Data Kategori</a></li>
              <li class="breadcrumb-item active">Tambah Kategori</li>
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
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Tambah Kategori</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('categories.store') }}" role="form">
                @csrf <!-- Tambahkan token CSRF -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama kategori">
                    </div>
                </div>
                <!-- /.card-body -->
            
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                </div>
            </form>
            
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    
@endsection
