<?php

namespace App\Filament\Resources\Stock\StockEntryTypeResource\Pages;

use App\Filament\Resources\Stock\StockEntryTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockEntryTypes extends ListRecords
{
    protected static string $resource = StockEntryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
