<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title> 
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form action="{{ route('user.login') }}" method="POST">
      @csrf <!-- Tambahkan token CSRF -->
      <div class="input-box">
        <input type="email" name="email" placeholder="Enter email Kamu" required> <!-- Tambahkan atribut name="email" -->
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Masukkan Password" id="password" required> <!-- Tambahkan atribut name="password" -->
        <!-- Tambahkan tombol toggle untuk menampilkan atau menyembunyikan password -->
        <span class="toggle-password" onclick="togglePasswordVisibility('password')"></span>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Login">
      </div>
      <div class="text">
        <h3>Belum Punya Akun? <a href="{{ route('user.register') }}">Daftar sekarang</a></h3>
      </div>
    </form>
  </div>

  <script src="js/login.js"></script>
</body>
</html>
