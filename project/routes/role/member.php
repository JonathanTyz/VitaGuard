<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:member'])->group(function () {
});