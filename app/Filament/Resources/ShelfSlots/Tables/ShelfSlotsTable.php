<?php

namespace App\Filament\Resources\ShelfSlots\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShelfSlotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shelf.name')
                    ->searchable(),
                TextColumn::make('label')
                    ->searchable(),
                TextColumn::make('led_from')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('led_to')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('oled_channel_front')
                    ->searchable(),
                TextColumn::make('oled_channel_back')
                    ->searchable(),
                TextColumn::make('current_product_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
