<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//LOGIN
Route::post('register', [UserController::class,'register']);
Route::post('register2', [UserController::class,'register2']);
Route::post('login', [UserController::class,'login1']);
// Route::get('jumlah', 'UserController@jmlh');
// Route::get('jumlahlelang', 'LelangController@jmlhlelang');
// Route::get('report', 'EmpController@getAllHistory');
// Route::get('/download', 'EmpController@download');

// ADMIN
Route::group(['middleware' => ['jwt.verify:admin']], function(){
    Route::post('register1', [UserController::class,'register1']);
    Route::put('edit-admin/{id}', 'UserController@editadmin');
    Route::resource('barang', BarangController::class);
    Route::resource('history', HistoryController::class);
    // Route::put('pilih/{id_history}', 'HistoryController@status');
});

// PETUGAS
Route::group(['middleware' => ['jwt.verify:petugas']], function(){
    Route::resource('barang1', BarangController::class);
    Route::resource('lelang', LelangController::class);
    Route::resource('history1', HistoryController::class);
    Route::put('pilih/{id_history}', 'HistoryController@status');
});

// PENGGUNA
Route::group(['middleware' => ['jwt.verify:pengguna']], function(){
    Route::post('menawar', 'HistoryController@store');
    Route::get('show_menawar\{id_history}', 'HistoryController@show');
});



