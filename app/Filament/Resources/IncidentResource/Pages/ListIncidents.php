<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use Filament\Actions;
use App\Filament\Widgets\IncidentMap;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\IncidentResource;

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            IncidentMap::class, // Add your widget here
        ];
    }
}
