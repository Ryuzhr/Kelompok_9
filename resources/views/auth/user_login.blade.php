<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="wrapper">
      <h2>Login</h2>
        <form action="{{ route('user.login') }}" method="POST">
            @csrf
            <div class="input-box">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" required>
            </div>
            @error('email')
                <small>{{ $message }}</small>
            @enderror
            <div class="input-box">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            @error('password')
                <small>{{ $message }}</small>
            @enderror
            <div class="input-box button">
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            </div>
            <h3>Belum Punya Akun? <a href="{{route('user.register')}}">Register Sekarang</a></h3>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ $message }}',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn-confirm-blue' // Gunakan kelas CSS kustom
                }
            });
        </script>
    @endif
    
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ $message }}',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn-confirm-blue' // Gunakan kelas CSS kustom
                }
            });
        </script>
    @endif
    
</body>
</html>
