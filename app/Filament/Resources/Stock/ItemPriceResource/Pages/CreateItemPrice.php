<?php

namespace App\Filament\Resources\Stock\ItemPriceResource\Pages;

use App\Filament\Resources\Stock\ItemPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItemPrice extends CreateRecord
{
    protected static string $resource = ItemPriceResource::class;
}
