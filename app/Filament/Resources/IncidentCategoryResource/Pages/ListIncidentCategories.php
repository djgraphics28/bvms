<?php

namespace App\Filament\Resources\IncidentCategoryResource\Pages;

use App\Filament\Resources\IncidentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentCategories extends ListRecords
{
    protected static string $resource = IncidentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
