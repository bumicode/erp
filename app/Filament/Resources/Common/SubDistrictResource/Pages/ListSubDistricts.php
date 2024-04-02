<?php

namespace App\Filament\Resources\Common\SubDistrictResource\Pages;

use App\Filament\Imports\Common\SubDistrictImporter;
use App\Filament\Resources\Common\SubDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubDistricts extends ListRecords
{
    protected static string $resource = SubDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(SubDistrictImporter::class),
        ];
    }
}
