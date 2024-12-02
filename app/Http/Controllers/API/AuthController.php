<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

/**
 * @group Authentication
 *
 * APIs for managing authentication
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * Log in a user and get an authentication token.
     *
     * @bodyParam email string required The user's email address. Example: user@example.com
     * @bodyParam password string required The user's password. Example: password123
     *
     * @response 200 {
     *   "token": "1|abcd1234",
     *   "user_type": "admin"
     * }
     * @response 401 {
     *   "error": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Check if the authenticated user is approved
            if (!auth()->user()->is_approved) {
                // Logout the user and return an error if not approved
                auth()->logout();
                return response()->json(['error' => 'Account not approved'], 403);
            }

            $token = auth()->user()->createToken('auth_token')->plainTextToken;
            $user_type = auth()->user()->user_type;

            return response()->json(['token' => $token, 'user_type' => $user_type], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }


    /**
     * Logout
     *
     * Log out the authenticated user.
     *
     * @authenticated
     *
     * @response 200 {
     *   "message": "Logged out"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }

    /**
     * Forgot Password
     *
     * Send a reset password link to the user's email.
     *
     * @bodyParam email string required The user's email address. Example: user@example.com
     *
     * @response 200 {
     *   "message": "Reset password link sent to your email"
     * }
     * @response 404 {
     *   "error": "User not found"
     * }
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgot', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message' => 'Reset password link sent to your email'], 200);
    }
}
