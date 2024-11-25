<?php

namespace App\Filament\Resources\IncidentCategoryResource\Pages;

use App\Filament\Resources\IncidentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncidentCategory extends EditRecord
{
    protected static string $resource = IncidentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
