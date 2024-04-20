<?php

namespace App\Filament\Resources\Stock\ItemResource\Pages;

use App\Filament\Resources\Stock\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use ZeeshanTariq\FilamentAttachmate\Core\HandleAttachments;

class EditItem extends EditRecord
{
    use HandleAttachments;

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
