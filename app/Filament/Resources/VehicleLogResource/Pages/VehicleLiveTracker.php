<?php

namespace App\Filament\Resources\VehicleLogResource\Pages;

use App\Models\Vehicle;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\VehicleLogResource;

class VehicleLiveTracker extends Page
{
    protected static string $resource = VehicleLogResource::class;

    protected static string $view = 'filament.resources.vehicle-log-resource.pages.vehicle-live-tracker';

    public function mount($record): void
    {
        $this->vehicle = Vehicle::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'vehicle' => $this->vehicle->fresh(), // Refresh data
            'lat' => $this->vehicle->device->latitude ?? 0,
            'lng' => $this->vehicle->device->longitude ?? 0,
            'googleMapApiKey' => env('GOOGLE_MAP_API_KEY'),
        ];
    }

    public function getPollingInterval(): ?string
    {
        return '5s';
    }
}
