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
    Route::put('/update-password', [ProfileController::class, 'updatePassword']);

    /**
     * @group Incident Management
     */
    Route::resource('incidents', IncidentController::class);
    Route::get('incident-categories', [IncidentController::class,'getIncidentCategories']);

    /**
     * @group Vehicle Management
     */
    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicle-login/{id}', [VehicleController::class, 'vehicleLogIn']);
    Route::put('vehicle-logout/{id}', [VehicleController::class, 'vehicleLogOut']);
    Route::get('vehicle-logs', [VehicleController::class, 'getVehicleLogs']);

    //Device
    Route::post('/update-location/{code}', [VehicleController::class, 'updateLocation'])->name('update.location');


    /**
     * @group User Management
     */
    Route::get('/drivers', [UsersController::class, 'drivers']);
    Route::get('/admins', [UsersController::class, 'admins']);

    Route::post('/create-driver-account', [UsersController::class, 'createDriverAccount']);
});
