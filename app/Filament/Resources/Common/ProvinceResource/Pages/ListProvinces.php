<?php

namespace App\Filament\Resources\Common\ProvinceResource\Pages;

use App\Filament\Imports\Common\ProvinceImporter;
use App\Filament\Resources\Common\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProvinces extends ListRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(ProvinceImporter::class),
        ];
    }
}
