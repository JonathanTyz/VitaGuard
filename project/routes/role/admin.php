<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    #region APP ROUTES
    #endregion

    #region VIEW ROUTES
    Route::view("/admin/home","admin.index")->name('admin.home');
    #endregion
});