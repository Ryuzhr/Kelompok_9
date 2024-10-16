<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form in HTML CSS | CodingLab</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="wrapper">
    <h2>Login Admin</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div class="input-box">
            <input type="email" name="email" placeholder="Enter email Kamu" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>
        <div class="input-box button">
            <input type="submit" value="Login">
        </div>
        <h3>Belum Punya Akun <a href="{{ route('admin.register') }}">Register Sekarang</a></h3>
    </form>
</div>
</body>
</html>
