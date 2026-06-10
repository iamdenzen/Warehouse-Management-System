<?php

namespace App\Filament\Resources\ShelfSlots;

use App\Filament\Resources\ShelfSlots\Pages\CreateShelfSlot;
use App\Filament\Resources\ShelfSlots\Pages\EditShelfSlot;
use App\Filament\Resources\ShelfSlots\Pages\ListShelfSlots;
use App\Filament\Resources\ShelfSlots\Schemas\ShelfSlotForm;
use App\Filament\Resources\ShelfSlots\Tables\ShelfSlotsTable;
use App\Models\ShelfSlot;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShelfSlotResource extends Resource
{
    protected static ?string $model = ShelfSlot::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return ShelfSlotForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShelfSlotsTable::configure($table);
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
            'index' => ListShelfSlots::route('/'),
            'create' => CreateShelfSlot::route('/create'),
            'edit' => EditShelfSlot::route('/{record}/edit'),
        ];
    }
}
