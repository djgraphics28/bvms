<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'location' => 'array', // Automatically decode JSON to array
    ];

    protected $guarded = [];

    /**
     * Get the vehicle associated with the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'device_id', 'id: ');
    }

    public function location(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => json_encode([
                'lat' => (float) $attributes['latitude'],
                'lng' => (float) $attributes['longitude'],
            ]),
            set: fn($value) => [
                'latitude' => $value['lat'],
                'longitude' => $value['lng'],
            ],
        );
    }
}
