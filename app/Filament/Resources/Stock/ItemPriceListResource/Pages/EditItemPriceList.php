<?php

namespace App\Filament\Resources\Stock\ItemPriceListResource\Pages;

use App\Filament\Resources\Stock\ItemPriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemPriceList extends EditRecord
{
    protected static string $resource = ItemPriceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
