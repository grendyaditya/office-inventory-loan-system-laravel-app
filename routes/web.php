<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StatusPermohonanController;
use App\Http\Controllers\PengembalianBarangController;
use App\Http\Controllers\PermohonanPinjamanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Rute untuk barang
    Route::resource('barang', BarangController::class);

    // Rute untuk permohonan pinjaman
    Route::resource('permohonan', PermohonanPinjamanController::class);
    Route::get('/permohonan/riwayat', [PermohonanPinjamanController::class, 'show'])->name('permohonan.riwayat');

    // Rute untuk status permohonan
    Route::resource('status_permohonan', StatusPermohonanController::class)->only(['index']);
    Route::post('/status_permohonan/{id}/izin', [StatusPermohonanController::class, 'izin'])->name('status_permohonan.izin');
    Route::post('/status_permohonan/{id}/tolak', [StatusPermohonanController::class, 'tolak'])->name('status_permohonan.tolak');

    // Rute untuk pengembalian barang
    Route::get('/pengembalian', [PengembalianBarangController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian', [PengembalianBarangController::class, 'store'])->name('pengembalian.store');
    
});


Route::group(['middleware' => ['guest']],function (){
    Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'dologin'])->name('dologin');
});


Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::post('/register', [HomeController::class, 'doregister'])->name('doregister');

Route::get('/teskon', [HomeController::class, 'testcon']);
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

