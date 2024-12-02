<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Create Driver Account
     *
     * Creates a new driver account with user and driver details.
     *
     * @authenticated
     *
     * @bodyParam first_name string required The first name of the driver. Example: John
     * @bodyParam middle_name string optional The middle name of the driver. Example: Smith
     * @bodyParam last_name string required The last name of the driver. Example: Doe
     * @bodyParam email string required The email address of the driver. Must be unique. Example: john.doe@example.com
     * @bodyParam driver_license_number string required The driver's license number. Example: ABC123XYZ
     *
     * @response 201 {
     *   "message": "Driver account created successfully"
     * }
     */
    public function createDriverAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'driver_license_number' => 'required|string|max:255',
        ]);

        Driver::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'driver_license_number' => $request->driver_license_number,
            'barangay_id' => $request->user()->barangay_id,
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->last_name),
            'user_type' => 'driver',
            'barangay_id' => $request->user()->barangay_id
        ]);

        $user->driverDetail()->update([
            'user_id' => $user->id
        ]);

        return response()->json(['message' => 'Driver account created successfully'], 201);
    }
}
