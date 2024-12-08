<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Incident;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use App\Filament\Resources\IncidentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\IncidentResource\RelationManagers;
use App\Filament\Widgets\IncidentMap;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                LocationPickr::make('location')
                    ->columnSpanFull()
                    ->mapControls([
                        'mapTypeControl'    => true,
                        'scaleControl'      => true,
                        'streetViewControl' => true,
                        'rotateControl'     => true,
                        'fullscreenControl' => true,
                        'zoomControl'       => true,
                    ])
                    ->defaultZoom(15)
                    ->draggable()
                    ->clickable()
                    ->height('40vh')
                    ->defaultLocation([16.05056031522701, 120.58785711651207])
                    ->myLocationButtonLabel('My location')
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('latitude', $state['lat']);
                            $set('longitude', $state['lng']);
                        }
                    }),
                // Forms\Components\TextInput::make('location')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->required()
                    ->default('low'),
                Forms\Components\Select::make('type')
                    ->options([
                        'incident' => 'Incident',
                        'request' => 'Request',
                    ])
                    ->required()
                    ->default('incident'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'rejected' => 'Rejected',
                        'approved' => 'Approved',
                        'completed' => 'Completed',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\Select::make('user_id')
                    ->label('Creator')
                    ->relationship('creator', 'name')
                    ->required(),
                Forms\Components\Select::make('incident_category_id')
                    ->relationship('incident_category', 'name')
                    ->required(),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            IncidentMap::class, // Add your widget here
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('incident_category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
