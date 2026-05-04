<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    #region APP ROUTES
    #endregion

    #region VIEW ROUTES
    Route::view("/home","admin.index")->name('home');
    #endregion
});