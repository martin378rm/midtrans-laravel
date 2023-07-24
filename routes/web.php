<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::post('logout_member', [AuthController::class, 'logout_member']);
Route::get('login', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);


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

// payment
Route::get('/payment', [PaymentController::class, 'list']);