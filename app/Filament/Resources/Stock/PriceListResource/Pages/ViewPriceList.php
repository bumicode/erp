<?php

namespace App\Filament\Resources\Stock\PriceListResource\Pages;

use App\Filament\Resources\Stock\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPriceList extends ViewRecord
{
    protected static string $resource = PriceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
