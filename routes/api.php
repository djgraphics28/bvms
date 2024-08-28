<?php

use App\Http\Controllers\API\BarangayController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UsersController::class, 'index'])->name('api.users.index');
Route::get('/barangays', [BarangayController::class, 'index'])->name('api.barangay.index');
