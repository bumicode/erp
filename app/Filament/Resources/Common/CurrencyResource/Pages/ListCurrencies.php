<?php

namespace App\Filament\Resources\Common\CurrencyResource\Pages;

use App\Filament\Resources\Common\CurrencyResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListCurrencies extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
