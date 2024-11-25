<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleLogResource\Pages;
use App\Filament\Resources\VehicleLogResource\RelationManagers;
use App\Models\VehicleLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleLogResource extends Resource
{
    protected static ?string $model = VehicleLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'code')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->code . ' - ' . $record->model . ' - ' . $record->brand. ' - ' . $record->plate_number)
                    ->required(),
                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'first_name')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('destination')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('entry_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('exit_time'),
                Forms\Components\TextInput::make('purpose')
                    ->maxLength(255),
                Forms\Components\TextInput::make('remarks')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('destination')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entry_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exit_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purpose')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
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
            'index' => Pages\ListVehicleLogs::route('/'),
            'create' => Pages\CreateVehicleLog::route('/create'),
            'edit' => Pages\EditVehicleLog::route('/{record}/edit'),
        ];
    }
}
