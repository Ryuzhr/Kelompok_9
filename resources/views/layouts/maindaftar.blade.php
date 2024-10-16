<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration or Sign Up form in HTML CSS | CodingLab</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="wrapper">
    <h2>Registration</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/daftar" method="POST">
        <div class="input-box">
            <input type="text" name="name" placeholder="Enter nama Kamu" required>
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Enter email Kamu" required>
        </div>
        <div class="input-box">
            <input type="text" name="address" placeholder="Masukkan Alamat Kamu" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>
        <div class="input-box">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        </div>
        @csrf
        <div class="input-box button">
            <input type="submit" value="Daftar">
        </div>
        <h3>Sudah Punya Akun <a href="{{route('user.login')}}">Login Sekarang</a></h3>
    </form>
</div>
</body>
</html>
