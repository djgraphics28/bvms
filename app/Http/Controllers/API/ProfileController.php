<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
     * Update User Password
     *
     * Updates the authenticated user's password after validating the old password
     *
     * @bodyParam old_password string required The user's current password. Example: currentpass123
     * @bodyParam new_password string required The new password (min 8 characters). Example: newpass123
     * @bodyParam new_password_confirmation string required Confirmation of the new password. Example: newpass123
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Password updated successfully"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Old password is incorrect"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "Failed to update password"
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required'
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is incorrect'
            ], 400);
        }

        try {
            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update password'
            ], 500);
        }
    }
}
