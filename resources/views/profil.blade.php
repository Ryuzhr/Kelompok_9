@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Edit Profil Pengguna</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Edit Profil Pengguna') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nama') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Alamat') }}</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">{{ __('Nomor Telepon') }}</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $user->telepon }}">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Gambar Profil') }}</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        @if ($user->image)
                        <div class="mb-3">
                            <label for="current_image" class="form-label">{{ __('Gambar Profil Saat Ini') }}</label>
                            <img src="{{ route('gambar.show', ['nama_file' => $user->image]) }}" alt="Gambar Profil" style="max-width: 200px;">
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
