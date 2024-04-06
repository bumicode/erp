<?php

namespace App\Filament\Resources\Stock\ItemPriceListResource\Pages;

use App\Filament\Resources\Stock\ItemPriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemPriceLists extends ListRecords
{
    protected static string $resource = ItemPriceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
