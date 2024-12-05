<?php

namespace App\Http\Controllers\API;

use App\Models\Incident;
use Illuminate\Http\Request;
use App\Models\IncidentCategory;
use App\Http\Controllers\Controller;

/**
 * @group Incident Management
 *
 * APIs for managing incidents
 */
class IncidentController extends Controller
{
    /**
     * Get a list of all incidents.
     *
     * @queryParam page int The page number for pagination. Example: 1
     * @queryParam per_page int The number of items per page. Example: 10
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Server Down",
     *       "description": "The main server is not responding.",
     *       "location": "Server Room",
     *       "priority": "high",
     *       "type": "incident",
     *       "status": "pending",
     *       "user_id": 5,
     *       "incident_category_id": 2,
     *       "created_at": "2024-11-18T12:00:00.000000Z",
     *       "updated_at": "2024-11-18T12:00:00.000000Z"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/incidents?page=1",
     *     "last": "http://example.com/api/incidents?page=10",
     *     "prev": null,
     *     "next": "http://example.com/api/incidents?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 10,
     *     "path": "http://example.com/api/incidents",
     *     "per_page": 10,
     *     "to": 10,
     *     "total": 100
     *   }
     * }
     */
    public function index(Request $request)
    {
        $barangayId = $request->user()->barangay_id;
        // Paginate incidents with 10 items per page
        $incidents = Incident::where('barangay_id', $barangayId)->get();

        return response()->json($incidents);
    }

    /**
     * Store a newly created incident in the database.
     *
     * @bodyParam title string required The title of the incident. Example: "Power Outage"
     * @bodyParam description string required A detailed description of the incident. Example: "There is a power outage in the building."
     * @bodyParam location string required The location where the incident occurred. Example: "Building A, Floor 3"
     * @bodyParam priority string The priority level of the incident. Example: "high" Allowed values: low, medium, high. Default: low.
     * @bodyParam type string The type of the record. Example: "request" Allowed values: incident, request. Default: incident.
     * @bodyParam status string The status of the incident. Example: "pending"
     * @bodyParam user_id int required The ID of the user reporting the incident. Example: 5
     * @bodyParam incident_category_id int required The ID of the incident category. Example: 2
     *
     * @response 201 {
     *   "id": 1,
     *   "title": "Power Outage",
     *   "description": "There is a power outage in the building.",
     *   "location": "Building A, Floor 3",
     *   "priority": "high",
     *   "type": "request",
     *   "status": "pending",
     *   "incident_category_id": 2,
     *   "created_at": "2024-11-18T12:00:00.000000Z",
     *   "updated_at": "2024-11-18T12:00:00.000000Z"
     * }
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'priority' => 'in:low,medium,high',
            'type' => 'in:incident,request',
            'status' => 'string',
            'incident_category_id' => 'required|exists:incident_categories,id',
        ]);

        $validatedData['user_id'] = $request->user()->id;

        // Create a new incident
        $incident = Incident::create($validatedData);

        return response()->json($incident, 201);
    }

    /**
     * Get details of a specific incident.
     *
     * @urlParam id int required The ID of the incident. Example: 1
     *
     * @response {
     *   "id": 1,
     *   "title": "Server Down",
     *   "description": "The main server is not responding.",
     *   "location": "Server Room",
     *   "priority": "high",
     *   "type": "incident",
     *   "status": "resolved",
     *   "user_id": 5,
     *   "incident_category_id": 2,
     *   "created_at": "2024-11-18T12:00:00.000000Z",
     *   "updated_at": "2024-11-18T12:00:00.000000Z"
     * }
     */
    public function show(string $id)
    {
        // Find the incident by ID
        $incident = Incident::find($id);

        // If not found, return 404
        if (!$incident) {
            return response()->json(['error' => 'Incident not found'], 404);
        }

        return response()->json($incident);
    }

    /**
     * Update an existing incident.
     *
     * @urlParam id int required The ID of the incident to update. Example: 1
     * @bodyParam title string The title of the incident. Example: "Network Failure"
     * @bodyParam description string A detailed description of the incident. Example: "The network connection is down in the west wing."
     * @bodyParam location string The location where the incident occurred. Example: "West Wing, Room 12"
     * @bodyParam priority string The priority level of the incident. Example: "medium" Allowed values: low, medium, high.
     * @bodyParam type string The type of the record. Example: "incident" Allowed values: incident, request.
     * @bodyParam status string The status of the incident. Example: "resolved"
     * @bodyParam user_id int The ID of the user reporting the incident. Example: 5
     * @bodyParam incident_category_id int The ID of the incident category. Example: 3
     *
     * @response 200 {
     *   "message": "Incident updated successfully"
     * }
     */
    public function update(Request $request, string $id)
    {
        // Find the incident by ID
        $incident = Incident::find($id);

        // If not found, return 404
        if (!$incident) {
            return response()->json(['error' => 'Incident not found'], 404);
        }

        // Validate the request
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'location' => 'string|max:255',
            'priority' => 'in:low,medium,high',
            'type' => 'in:incident,request',
            'status' => 'string',
            'incident_category_id' => 'exists:incident_categories,id',
        ]);

        // Update the incident
        $incident->update($validatedData);

        return response()->json(['message' => 'Incident updated successfully']);
    }

    /**
     * Delete a specific incident.
     *
     * @urlParam id int required The ID of the incident to delete. Example: 1
     *
     * @response 200 {
     *   "message": "Incident deleted successfully"
     * }
     */
    public function destroy(string $id)
    {
        // Find the incident by ID
        $incident = Incident::find($id);

        // If not found, return 404
        if (!$incident) {
            return response()->json(['error' => 'Incident not found'], 404);
        }

        // Delete the incident
        $incident->delete();

        return response()->json(['message' => 'Incident deleted successfully']);
    }

    /**
     * Get all incident categories.
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Vehicular Accident",
     *       "description": "vehicle accident",
     *     }
     *   ]
     * }
     */
    public function getIncidentCategories()
    {
        $categories = IncidentCategory::all();
        return response()->json($categories);
    }
}
