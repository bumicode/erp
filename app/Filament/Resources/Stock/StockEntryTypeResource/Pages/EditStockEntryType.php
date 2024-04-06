<?php

namespace App\Filament\Resources\Stock\StockEntryTypeResource\Pages;

use App\Filament\Resources\Stock\StockEntryTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockEntryType extends EditRecord
{
    protected static string $resource = StockEntryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
