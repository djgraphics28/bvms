<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group Profile Management
 *
 * APIs for managing user profiles
 */
class ProfileController extends Controller
{
    /**
     * Get User Profile
     *
     * Returns the authenticated user's profile information
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        //if user type == driver return users and driverDetail relation
        if (auth()->user()->type == 'driver') {
            return auth()->user()->load('driverDetail');
        } else {
            return auth()->user();
        }
    }

    /**
     * Update User Profile
     *
     * Updates the authenticated user's profile information
     *
     * @bodyParam name string Name of the user
     * @bodyParam email string Email of the user
     * @bodyParam phone string Phone number of the user
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        // if user_type is driver
        // if (auth()->user()->type == 'driver') {
        //     $driver = auth()->user()->driverDetail()->first();
        //     $driver->update($request->all());
        //     return $driver;
        // } else {
        //     auth()->user()->update($request->all());
        //     return auth()->user();
        // }
    }
}
