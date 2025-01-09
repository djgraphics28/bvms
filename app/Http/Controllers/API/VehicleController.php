<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Models\Vehicle;
use App\Models\VehicleLog;
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

    /**
     * Log Vehicle Out
     *
     * Create a new vehicle log entry when vehicle goes out
     *
     * @authenticated
     * @urlParam id required The ID of the vehicle
     * @bodyParam status string required The status of the vehicle (must be 'out')
     * @bodyParam purpose string required The purpose of the trip
     * @bodyParam driver string required The ID of the driver
     * @bodyParam destination string required The destination of the trip
     *
     * @response {
     *    "message": "Vehicle logged out successfully"
     * }
     *
     * @response 404 {
     *    "error": "Vehicle not found"
     * }
     *
     * @response 400 {
     *    "error": "Vehicle already go out today"
     * }
     */
    public function vehicleLogIn(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'purpose' => 'required',
            'driver' => 'required',
            'destination' => 'required',
        ]);

        $vehicle = Vehicle::find($id);

        // If not found, return 404
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Check if there's an existing log entry for today
        $existingLog = VehicleLog::where('vehicle_id', $id)
            ->whereDate('entry_time', today())
            ->latest()
            ->first();

        if ($request->status === 'out') {
            // Check if there's an entry log without exit time
            if ($existingLog && $existingLog->status === 'out') {
                return response()->json(['error' => 'Vehicle already go out today'], 400);
            }

            // Create new log entry
            VehicleLog::create([
                'vehicle_id' => $id,
                'status' => $request->status,
                'purpose' => $request->purpose,
                'destination' => $request->destination,
                'driver_id' => $request->driver,
                'barangay_id' => $request->user()->barangay_id,
                'entry_time' => now()
            ]);

            return response()->json(['message' => 'Vehicle logged out successfully']);
        }
    }

    /**
     * Log Vehicle Return
     *
     * Update vehicle log entry when vehicle returns
     *
     * @authenticated
     * @urlParam id required The ID of the vehicle
     * @bodyParam status string required The status of the vehicle (must be 'returned')
     *
     * @response {
     *    "message": "Vehicle return logged successfully"
     * }
     *
     * @response 404 {
     *    "error": "Vehicle not found"
     * }
     *
     * @response 400 {
     *    "error": "No active entry found for this vehicle today"
     * }
     */
    public function vehicleLogOut(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $vehicle = Vehicle::find($id);

        // If not found, return 404
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Check if there's an existing log entry for today
        $existingLog = VehicleLog::where('vehicle_id', $id)
            ->whereDate('entry_time', today())
            ->latest()
            ->first();

        if ($request->status === 'returned') {
            // Check if there's an entry log without exit time
            if (!$existingLog || $existingLog->status !== 'out') {
                return response()->json(['error' => 'No active entry found for this vehicle today'], 400);
            }

            // Update exit time for existing log
            $existingLog->update([
                'status' => 'returned',
                'exit_time' => now()
            ]);

            return response()->json(['message' => 'Vehicle return logged successfully']);
        }
    }

    /**
     * Get Vehicle Logs
     *
     * Get a list of vehicle logs for the authenticated user's barangay
     *
     * @authenticated
     *
     * @response {
     *  "data": [
     *    {
     *      "id": 1,
     *      "vehicle_id": 1,
     *      "barangay_id": 1,
     *      "status": "out",
     *      "purpose": "Official Business",
     *      "destination": "City Hall",
     *      "driver_id": 1,
     *      "entry_time": "2024-01-01 08:00:00",
     *      "exit_time": "2024-01-01 17:00:00"
     *    }
     *  ]
     * }
     */
    public function getVehicleLogs(Request $request)
    {
        $barangayId = $request->user()->barangay_id;

        $vehicleLogs = VehicleLog::where('barangay_id', $barangayId)->get();

        return response()->json($vehicleLogs);
    }

    public function updateLocation(Request $request, $code)
    {
        dd("error");
        try {
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            $location = [
                'lat' => $lat,
                'lng' => $lng
            ];

            $device = Device::where('code', $code)->first();

            if ($device) {
                $device->update(['location' => json_encode($location), 'latitude' => $lat, 'longitude' => $lng]);
            }
            return response()->json(['message' => 'Location updated successfully']);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update location',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
