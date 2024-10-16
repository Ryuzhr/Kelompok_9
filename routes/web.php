<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDataController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OwnerController;


Route::middleware(['auth', OwnerMiddleware::class])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/owner/kelolauser', [OwnerController::class, 'viewkelolauser'])->name('owner.kelolauser');
    Route::patch('/owner/users/{id}/role', [OwnerController::class, 'updateRole'])->name('owner.users.updateRole');
    Route::delete('/owner/users/{id}', [OwnerController::class, 'destroy'])->name('owner.users.destroy');
    Route::get('/owner/laporan-stok', [OwnerController::class, 'laporanStok'])->name('owner.laporan.stok');

});


Route::get('/riwayat-transaksi', [TransactionController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');





Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/dataproduk', [ProdukController::class, 'index'])->name('produks.index');
    Route::get('/produks/create', [ProdukController::class, 'create'])->name('produks.create');
    Route::post('/produks/store', [ProdukController::class, 'store'])->name('produks.store');
    Route::get('/produks/edit/{id}', [ProdukController::class, 'edit'])->name('produks.edit');
    Route::put('/produks/{id}', [ProdukController::class, 'update'])->name('produks.update');
    Route::delete('/produks/destroy/{id}', [ProdukController::class, 'destroy'])->name('produks.destroy');



    Route::get('/datatransaksi', [TransactionController::class, 'index'])->name('datatransaksi.index');

    Route::get('/datapesanan', [OrderDataController::class, 'index'])->name('datapesanan.index');

  
    Route::get('/datakategori', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    
});

Route::get('/produk', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produks/detail/{id}', [ProdukController::class, 'showdetail'])->name('produks.detail');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'byCategory'])->name('produk.byCategory');

Route::get('/Kategori', [CategoryController::class, 'navbar']);

Route::put('/order/{id}/update-status', [OrderDataController::class, 'updateStatus'])->name('order.updateStatus');
Route::delete('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
Route::get('/orders', [OrderController::class, 'index'])->name('order.index');

Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('user.register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');


Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');




// Route::get('/users', [AuthController::class, 'index'])->name('users.index');
// Route::get('/users/create', [AuthController::class, 'create'])->name('users.create');
// Route::post('/users/store', [AuthController::class, 'store'])->name('users.store');
// Route::get('/users/{id}', [AuthController::class, 'show'])->name('users.show');
// Route::get('/users/{id}/edit', [AuthController::class, 'edit'])->name('users.edit');
// Route::put('/users/{id}/update', [AuthController::class, 'update'])->name('users.update');
// Route::delete('/users/{id}/destroy', [AuthController::class, 'destroy'])->name('users.destroy');









Route::post('/register', [AuthController::class, 'register']);

// Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
Route::get('/gambar/{nama_file}', [GambarController::class, 'show'])->name('gambar.show');
Route::post('/profil/upload', 'ProfilController@uploadImage')->name('profil.upload');




// Route::get('/masuk', function () {
//     return view('masuk');
// });


Route::get('/home', [ProdukController::class, 'home'])->name('home');

Route::get('/', [ProdukController::class, 'home'])->name('home');



Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');




