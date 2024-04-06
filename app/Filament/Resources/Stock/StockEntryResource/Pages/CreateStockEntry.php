<?php

namespace App\Filament\Resources\Stock\StockEntryResource\Pages;

use App\Filament\Resources\Stock\StockEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockEntry extends CreateRecord
{
    protected static string $resource = StockEntryResource::class;
}
