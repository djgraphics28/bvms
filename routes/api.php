<?php

use App\Http\Controllers\API\IncidentController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\BarangayController;
use App\Http\Controllers\API\VehicleController;

/**
 * @group User Management
 */
Route::get('/users', [UsersController::class, 'index'])->name('api.users.index');
Route::get('/barangays', [BarangayController::class, 'index'])->name('api.barangay.index');

/**
 * @group Authentication
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    /**
     * @group Authentication
     */
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * @group Profile Management
     */
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);

    /**
     * @group Incident Management
     */
    Route::resource('incidents', IncidentController::class);

    /**
     * @group Vehicle Management
     */
    Route::resource('vehicles', VehicleController::class);

    /**
     * @group User Management
     */
    Route::get('/drivers', [UsersController::class, 'drivers']);
    Route::get('/admins', [UsersController::class, 'admins']);
});
