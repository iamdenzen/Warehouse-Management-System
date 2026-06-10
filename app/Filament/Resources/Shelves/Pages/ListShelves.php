<?php

namespace App\Filament\Resources\Shelves\Pages;

use App\Filament\Resources\Shelves\ShelfResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShelves extends ListRecords
{
    protected static string $resource = ShelfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
