<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LelangController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;

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

// LOGIN AND REGISTER
Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/', [UserController::class, 'login'])->name('postlogin');

// REGISTER PETUGAS
Route::get('/register-petugas', function(){
    return view('/petugas-tambah');
})->name('tambahpetugas');
Route::post('/petugas', [UserController::class, 'register1'])->name('registerpetugas');

// REGISTER PENGGUNA
Route::get('/register', function(){
    return view('register');
});
Route::post('/postregister', [UserController::class, 'register2'])->name('postregister');

// LOGOUT
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){

    // DASHBOARD    
    Route::get('/dashboard', [Homecontroller::class, 'jmlh'])->name('dashboard');
    Route::get('/getpdf', [PdfController::class, 'getPDF']);


    // Admin
    Route::get('/admin', [UserController::class, 'showadmin'])->name('getadmin');
    Route::get('/showadmin/{id}', [UserController::class, 'showeditadmin'])->name('showadmin');
    Route::post('/editadmin/{id}', [UserController::class, 'editadmin'])->name('editadmin');
    Route::delete('/deleteadmin/{id}', [UserController::class, 'hapusadmin'])->name('deleteadmin');

    // Petugas
    Route::get('/petugas', [UserController::class, 'showpetugas'])->name('getpetugas');
    Route::get('/showpetugas/{id}', [UserController::class, 'showeditpetugas'])->name('showpetugas');
    Route::post('/editpetugas/{id}', [UserController::class, 'editpetugas'])->name('editpetugas');
    Route::delete('/deletepetugas/{id}', [UserController::class, 'hapuspetugas'])->name('deletepetugas');

    // Pengguna
    Route::get('/pengguna', [UserController::class, 'showpengguna'])->name('getpengguna');
    Route::get('/showpengguna/{id}', [UserController::class, 'showeditpengguna'])->name('showpengguna');
    Route::post('/editpengguna/{id}', [UserController::class, 'editpengguna'])->name('editpengguna');
    Route::delete('/deletepengguna/{id}', [UserController::class, 'hapuspengguna'])->name('deletepengguna');

    // Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('getbarang');
    Route::get('/barangtambah', [BarangController::class, 'create']);
    Route::post('/tambahbarang', [BarangController::class, 'store'])->name('tambahbarang');
    Route::get('/showbarang/{id_barang}', [BarangController::class, 'edit'])->name('showbarang');
    Route::post('/editbarang/{id_barang}', [BarangController::class, 'update'])->name('editbarang');
    Route::delete('/deletebarang/{id_barang}', [BarangController::class, 'destroy'])->name('deletebarang');

    // Lelang
    Route::get('/lelang', [LelangController::class, 'index'])->name('getlelang');
    Route::get('/lelangtambah', [LelangController::class, 'create'])->name('showlelang');
    Route::post('/tambahlelang', [LelangController::class, 'store'])->name('tambahlelang');

    // PENAWARAN
    Route::post('/penawaran', [HistoryController::class, 'store'])->name('penawaran');

    // History
    Route::get('/history/{id_lelang}', [HistoryController::class, 'show'])->name('detaillelang');
    Route::post('/pemenang/{id_history}', [HistoryController::class, 'status'])->name('pemenang');

    // REPORT
    Route::get('/report/{id_lelang}', [HomeController::class, 'getId'])->name('report');
    Route::get('/download/report/{id_lelang}', [HomeController::class, 'download'])->name('download-report');

});