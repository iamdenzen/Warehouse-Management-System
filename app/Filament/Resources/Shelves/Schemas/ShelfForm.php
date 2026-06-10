<?php

namespace App\Filament\Resources\Shelves\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ShelfForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('station_id')
                    ->relationship('station', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('rows')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('columns')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
