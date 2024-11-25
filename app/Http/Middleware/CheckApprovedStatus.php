<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApprovedStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the 'approved_date' is null
            if (!$user->is_approved) {
                // Logout the user
                Auth::logout();

                // Return an error response for the API
                return response()->json([
                    'message' => 'Your account has not been approved yet.',
                ], 403); // 403 Forbidden status code
            }
        }

        return $next($request);
    }
}
