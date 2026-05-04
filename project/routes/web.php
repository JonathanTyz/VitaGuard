<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

#region MAIN APP ROUTE
#region AUTH
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
#endregion
#endregion

#region MAIN VIEW ROUTE
Route::view('/', 'landing')->name('landing');
Route::view('/login', 'auth.login')->name('login');
Route::view('/articles','articles.index')->name('articles');
Route::view('/articles/{id}','articles.read')->name('read-articles');
#endregion