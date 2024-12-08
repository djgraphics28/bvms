<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'code' => $this->code,
            'brand' => $this->brand,
            'model' => $this->model,
            'photo' => config('app.url').'/storage/'.$this->photo,
            'color' => $this->color,
            'status' => $this->status,
            'barangay' => $this->barangay->name,
            'plate_number' => $this->plate_number,
            'latitude' => $this->device ? $this->device->latitude ?? "16.050200" : "16.050200",
            'longitude' => $this->device ? $this->device->longitude ?? "120.587310" : "120.587310",
            'location' => $this->device ? $this->device->location ?? '' : '',
            'device_image' => $this->device && $this->device->image ? config('app.url').'/storage/'.$this->device->image : '',            // 'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
