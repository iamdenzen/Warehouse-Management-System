<?php

namespace App\Filament\Resources\ShelfSlots\Pages;

use App\Filament\Resources\ShelfSlots\ShelfSlotResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShelfSlot extends EditRecord
{
    protected static string $resource = ShelfSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
