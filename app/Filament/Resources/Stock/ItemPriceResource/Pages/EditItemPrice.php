<?php

namespace App\Filament\Resources\Stock\ItemPriceResource\Pages;

use App\Filament\Resources\Stock\ItemPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemPrice extends EditRecord
{
    protected static string $resource = ItemPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
