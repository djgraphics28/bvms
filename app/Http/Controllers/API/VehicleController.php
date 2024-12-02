<?php

namespace App\Http\Controllers\API;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\VehicleResource;

/**
 * @group Vehicle Management
 *
 * APIs for managing vehicles
 */
class VehicleController extends Controller
{
    /**
     * List Vehicles
     *
     * Get a list of vehicles for the authenticated user's barangay
     *
     * @authenticated
     *
     * @response {
     *  "data": [
     *    {
     *      "id": 1,
     *      "barangay_id": 1,
     *      "status": "active"
     *    }
     *  ]
     * }
     */
    public function index(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $vehicles = Vehicle::where('barangay_id', $barangayId)->get();
        return response()->json(VehicleResource::collection($vehicles));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update Vehicle Status
     *
     * Update the status of a specific vehicle
     *
     * @authenticated
     * @urlParam id required The ID of the vehicle
     * @bodyParam status string required The new status of the vehicle
     *
     * @response {
     *    "message": "Vehicle Status updated successfully"
     * }
     *
     * @response 404 {
     *    "error": "Vehicle not found"
     * }
     */
    public function update(Request $request, string $id)
    {
         // Find the incident by ID
         $vehicle = Vehicle::find($id);

         // If not found, return 404
         if (!$vehicle) {
             return response()->json(['error' => 'Vehicle not found'], 404);
         }

         // Update the incident
         $vehicle->update(['status', $request->status]);

         return response()->json(['message' => 'Vehicle Status updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
