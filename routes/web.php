<?php

use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestimoniController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// admin
Route::get('login', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);

// user login
Route::get('login_member', [AuthController::class, 'login_member']);
Route::post('login_member', [AuthController::class, 'login_member_action']);
Route::get('logout_member', [AuthController::class, 'logout_member']);

// user register
Route::get('register_member', [AuthController::class, 'register_member']);
Route::post('register_member', [AuthController::class, 'register_member_action']);


// dashboard
Route::get('dashboard', [DashboardController::class, 'index']);

// category
Route::get('kategori', [CategoryController::class, 'list']);

// subcategory
Route::get('subkategori', [SubcategoryController::class, 'list']);
// slider
Route::get('slider', [SliderController::class, 'list']);
// product
Route::get('barang', [ProductController::class, 'list']);
// testimoni
Route::get('testimoni', [TestimoniController::class, 'list']);
// review
Route::get('review', [ReviewController::class, 'list']);

// orders
Route::get('pesanan/baru', [OrderController::class, 'list']);
Route::get('pesanan/dikonfirmasi', [OrderController::class, 'dikonfirmasi_list']);
Route::get('pesanan/dikemas', [OrderController::class, 'dikemas_list']);
Route::get('pesanan/dikirim', [OrderController::class, 'dikirim_list']);
Route::get('pesanan/diterima', [OrderController::class, 'diterima_list']);
Route::get('pesanan/selesai', [OrderController::class, 'selesai_list']);


//report
Route::get('/laporan', [ReportController::class, 'index']);

// about
Route::get('/tentang', [TentangController::class, 'index']);
Route::post('/tentang/{about}', [TentangController::class, 'update']);



// payment
Route::get('/payment', [PaymentController::class, 'list']);


// home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/products/{category}', [HomeController::class, 'products']);
Route::get('/product/{id}', [HomeController::class, 'product']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/orders', [HomeController::class, 'orders']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/faq', [HomeController::class, 'faq']);


// add to cart
Route::post('/cart', [HomeController::class, 'add_to_cart']);

Route::get('/delete_from_cart/{cart}', [HomeController::class, 'delete_from_cart']);
Route::get('/city/{id}', [HomeController::class, 'get_city']);
Route::get('/get_ongkir/{tujuan}/{weight}', [HomeController::class, 'get_ongkir']);