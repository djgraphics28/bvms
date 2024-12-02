<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use App\Http\Resources\API\DriverResource;
use App\Http\Resources\API\VehicleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleLogsResource extends JsonResource
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
            'vehicle_id' => $this->vehicle_id,
            'vehicle' => new VehicleResource($this->vehicle),
            'driver_id' => $this->driver_id,
            'driver' => new DriverResource($this->driver),
            'entry_time' => $this->start_time,
            'exit_time' => $this->exit_time,
            'purpose' => $this->purpose,
            'destination' => $this->destination,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]
    }
}
