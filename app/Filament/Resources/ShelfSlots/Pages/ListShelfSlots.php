<?php

namespace App\Filament\Resources\ShelfSlots\Pages;

use App\Filament\Resources\ShelfSlots\ShelfSlotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShelfSlots extends ListRecords
{
    protected static string $resource = ShelfSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
