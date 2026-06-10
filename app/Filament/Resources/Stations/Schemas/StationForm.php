<?php

namespace App\Filament\Resources\Stations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class StationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('esp32_led_host')
                    ->required(),
                TextInput::make('esp32_scale_host')
                    ->required(),
                TextInput::make('esp32_oled_host')
                    ->required(),
                Select::make('printer_id')
                    ->relationship('printer', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('weight_tolerance_grams')
                    ->required()
                    ->numeric()
                    ->default(50),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
