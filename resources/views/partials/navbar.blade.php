<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <head>
      <style>
           .cart-badge {
            position: absolute;
            top: -1px;
            right: -3px;
            font-size: 10px;
            background-color: transparent;
            color: white;
            padding: 5px 5px;
            border-radius: 50%;
            display: none;
        }

        .nav-item .nav-link {
            position: relative;
        }

        .search-form {
            position: relative;
            width: 70%;
        }

        .search-input {
            border-radius: 30px; 
            border: 1px solid #ced4da; 
        }

        .search-button {
            border-radius: 30px; 
        }
      </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-3">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/produk">Produk</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownKategori" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Kategori
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownKategori">
                @foreach($categories as $category)
                    <li><a class="dropdown-item" href="{{ route('produk.byCategory', $category->id) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
          </li>
        </li>
        <li class="nav-item">
          <form class="d-flex" action="{{ route('produk.search') }}" method="GET">
            <input class="form-control w-80 search-input" type="search" name="query" placeholder="Cari produk..." aria-label="Search" value="{{ request()->input('query') }}">
          </form>
        </li>
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0 ms-3">
          @auth 
            @if(Auth::user()->image)
              <li class="nav-item">
                <a class="nav-link" href="/profil">
                  <img src="{{ route('gambar.show', ['nama_file' => Auth::user()->image]) }}" alt="Gambar Profil" class="rounded-circle" width="30" height="30">
                </a>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a>
              </li>
            @endif
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
              </a> 
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                <li><a class="dropdown-item" href="/profil">Profil Saya</a></li>
                <li><a class="dropdown-item" href="{{ route('order.index') }}">Pesanan Saya</a></li>
                <li><a class="dropdown-item" href="{{route ('riwayat.transaksi')}}">Riwayat Transaksi</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                  <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route ('user.register')}}">Daftar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route ('user.login')}}">Masuk</a>
            </li>
          @endauth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.index') }}">
                <i class="bi bi-cart-fill"></i>
                <span class="cart-badge">{{ isset($cartCount) && $cartCount > 0 ? $cartCount : '' }}</span>
            </a>
          </li>     
        </ul>
      </div>
    </div>
  </nav>
  

    <!-- Konten Halaman lainnya -->

    <script>
      function addToCart(productId) {
          $.ajax({
              url: '{{ route("cart.add") }}',
              method: 'POST',
              data: {
                  product_id: productId,
                  quantity: 1,
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  const cartCount = response.cartCount;
  
                  if (cartCount > 0) {
                      $('.cart-badge').text(cartCount).show();
                  } else {
                      $('.cart-badge').hide();
                  }
  
                  alert(response.success);
              },
              error: function(xhr) {
                  alert(xhr.responseJSON.error);
              }
          });
      }
  
      $(document).ready(function() {
          const cartCount = {{ isset($cartCount) ? $cartCount : 0 }};
          if (cartCount > 0) {
              $('.cart-badge').show();
          }
      });
  </script>
  
</body>
</html>
