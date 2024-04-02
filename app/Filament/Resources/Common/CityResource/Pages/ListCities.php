<?php

namespace App\Filament\Resources\Common\CityResource\Pages;

use App\Filament\Imports\Common\CityImporter;
use App\Filament\Resources\Common\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(CityImporter::class),
        ];
    }
}
