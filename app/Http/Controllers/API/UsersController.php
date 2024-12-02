<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group User Management
 *
 * APIs for managing users
 */
class UsersController extends Controller
{
    /**
     * Get Drivers List
     *
     * Display lists of drivers in the barangay.
     *
     * @authenticated
     * @response scenario=success {
     *  "id": 1,
     *  "name": "John Doe",
     *  "email": "john@example.com",
     *  "user_type": "driver",
     *  "barangay_id": 1
     * }
     */
    public function drivers(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $users = User::where('barangay_id', $barangayId)->where('user_type', 'driver')->get();
        return response()->json($users);
    }

    /**
     * Get Driver Information
     *
     * Get detailed information of authenticated driver.
     *
     * @authenticated
     * @response scenario=success {
     *  "id": 1,
     *  "name": "John Doe",
     *  "email": "john@example.com",
     *  "user_type": "driver",
     *  "barangay_id": 1,
     *  "driver_detail": {
     *      "id": 1,
     *      "user_id": 1,
     *      "license_number": "ABC123"
     *  }
     * }
     */
    public function driverInfo(Request $request)
    {
        $driverId = $request->user()->id;

        $user = User::where('id', $driverId)->with('driverDetail')->first();
        return response()->json($user);
    }

    /**
     * Get Admins List
     *
     * Display lists of admins in the barangay.
     *
     * @authenticated
     * @response scenario=success {
     *  "id": 1,
     *  "name": "Jane Doe",
     *  "email": "jane@example.com",
     *  "user_type": "admin",
     *  "barangay_id": 1
     * }
     */
    public function admins(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $users = User::where('barangay_id', $barangayId)->where('user_type', 'admin')->get();
        return response()->json($users);
    }

}
