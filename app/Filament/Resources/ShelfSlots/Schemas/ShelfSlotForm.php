<?php

namespace App\Filament\Resources\ShelfSlots\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ShelfSlotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('shelf_id')
                    ->relationship('shelf', 'name')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('led_from')
                    ->required()
                    ->numeric(),
                TextInput::make('led_to')
                    ->required()
                    ->numeric(),
                TextInput::make('oled_channel_front')
                    ->required(),
                TextInput::make('oled_channel_back')
                    ->required(),
                TextInput::make('current_product_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
