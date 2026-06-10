<?php

namespace App\Filament\Resources\Shelves\Pages;

use App\Filament\Resources\Shelves\ShelfResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShelf extends EditRecord
{
    protected static string $resource = ShelfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
