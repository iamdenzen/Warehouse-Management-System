<?php

namespace App\Filament\Resources\Shelves;

use App\Filament\Resources\Shelves\Pages\CreateShelf;
use App\Filament\Resources\Shelves\Pages\EditShelf;
use App\Filament\Resources\Shelves\Pages\ListShelves;
use App\Filament\Resources\Shelves\Schemas\ShelfForm;
use App\Filament\Resources\Shelves\Tables\ShelvesTable;
use App\Models\Shelf;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShelfResource extends Resource
{
    protected static ?string $model = Shelf::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ShelfForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShelvesTable::configure($table);
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
            'index' => ListShelves::route('/'),
            'create' => CreateShelf::route('/create'),
            'edit' => EditShelf::route('/{record}/edit'),
        ];
    }
}
