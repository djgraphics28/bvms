<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barangay;

class BarangayController extends Controller
{
    public function index()
    {
        return Barangay::all();
    }
}
