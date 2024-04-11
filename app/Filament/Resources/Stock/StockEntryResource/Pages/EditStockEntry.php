<?php

namespace App\Filament\Resources\Stock\StockEntryResource\Pages;

use App\Filament\Resources\Stock\StockEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockEntry extends EditRecord
{
    protected static string $resource = StockEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
