<?php

namespace App\Filament\Resources\Common\CountryResource\Pages;

use App\Filament\Resources\Common\CountryResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListCountries extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
