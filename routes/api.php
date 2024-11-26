<?php

use App\Http\Controllers\API\IncidentController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\BarangayController;
use App\Http\Controllers\API\VehicleController;

Route::get('/users', [UsersController::class, 'index'])->name('api.users.index');
Route::get('/barangays', [BarangayController::class, 'index'])->name('api.barangay.index');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);

    Route::resource('incidents', IncidentController::class);
    Route::resource('vehicles', VehicleController::class);

    Route::get('/drivers', [UsersController::class, 'drivers']);
    Route::get('/admins', [UsersController::class, 'admins']);
});
