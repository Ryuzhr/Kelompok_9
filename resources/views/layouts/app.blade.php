<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/profil.css"> <!-- As specified in layouts.app -->
    <link rel="stylesheet" href="css/home.css"> <!-- Additional stylesheet from mainproduk.blade.php -->
    <script src="{{ asset('js/cart.js') }}"></script>



    <title>@yield('title', 'Profil Saya')</title> <!-- Default title can be overridden by child views -->
  </head>
  <body>

    @include('partials.navbar') <!-- Including the navbar -->

    <main class="container mt-4">
        @yield('content')
        <!-- The content section where specific page content will be inserted -->
    </main>

    @include('partials.footer') <!-- Including the footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
