<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    #region API ROUTES (TEMPORARY)
    #endregion

    #region VIEW ROUTES
    Route::view("/home","home.index")->name('home');
    #endregion
});