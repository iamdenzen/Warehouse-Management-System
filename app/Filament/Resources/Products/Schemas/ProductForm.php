<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),
                TextInput::make('name')
                    ->required(),
                TextInput::make('weight_grams')
                    ->label('Weight (grams)')
                    ->required()
                    ->numeric()
                    ->minValue(0.1),
                Toggle::make('active')
                    ->default(true),
            ]);
    }
}
