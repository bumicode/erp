<?php

namespace App\Filament\Resources\Stock\StockEntryResource\Pages;

use App\Filament\Resources\Stock\StockEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStockEntry extends ViewRecord
{
    protected static string $resource = StockEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
