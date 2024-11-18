<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        //if user type == driver return users and driverDetail relation
        if (auth()->user()->type == 'driver') {
            return auth()->user()->load('driverDetail');
        } else {
            return auth()->user();
        }
    }

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
