<?php

namespace App\Filament\Resources\Stock\PriceListResource\Pages;

use App\Filament\Resources\Stock\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriceList extends EditRecord
{
    protected static string $resource = PriceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
