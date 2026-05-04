<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:facility_admin'])->group(function () {
});