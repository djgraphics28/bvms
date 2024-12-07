<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'barangay_id' => $this->barangay_id,
            'barangay' => $this->barangay->name,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'priority' => $this->priority,
            'type' => $this->type,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'incident_category_id' => $this->incident_category->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'contact_number' => $this->contact_number,
            'reporter' => $this->reporter,
            'email' => $this->email,
            'date_time' => $this->date_time
        ];
    }
}
