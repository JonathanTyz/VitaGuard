<?php

use App\Http\Controllers\ChatDokterController;
use App\Http\Controllers\DaftarDokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsultasiOfflineController;
use App\Http\Controllers\RiwayatKonsultasiController;
use Illuminate\Support\Facades\Route;

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

Route::resource('home', HomeController::class);
Route::resource('chat-dokter', ChatDokterController::class);
Route::resource('daftar-dokter', DaftarDokterController::class);
Route::resource('konsultasi-offline', KonsultasiOfflineController::class);
Route::resource('riwayat-konsultasi', RiwayatKonsultasiController::class);

// testing routes for error
// Route::get('/test-404', function () {
//     abort(404);
// });