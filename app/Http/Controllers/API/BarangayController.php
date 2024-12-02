<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barangay;

/**
 * @group Barangay Management
 *
 * APIs for managing barangays
 */
class BarangayController extends Controller
{
    /**
     * List all barangays
     *
     * Get a list of all barangays in the system
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Barangay::all();
    }
}
