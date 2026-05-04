<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:doctor'])->group(function () {
});