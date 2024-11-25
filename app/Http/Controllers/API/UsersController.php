<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display lists of drivers.
     */
    public function drivers(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $users = User::where('barangay_id', $barangayId)->where('user_type', 'driver')->get();
        return response()->json($users);
    }

    //get driver info
    public function driverInfo(Request $request)
    {
        $driverId = $request->user()->id;

        $user = User::where('id', $driverId)->with('driverDetail')->first();
        return response()->json($user);
    }

    /**
     * Display lists of admins.
     */
    public function admins(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $users = User::where('barangay_id', $barangayId)->where('user_type', 'admin')->get();
        return response()->json($users);
    }

}
