<?php

namespace App\Filament\Resources\Common\VillageResource\Pages;

use App\Filament\Imports\Common\VillageImporter;
use App\Filament\Resources\Common\VillageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillages extends ListRecords
{
    protected static string $resource = VillageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(VillageImporter::class)
                ->maxRows(5000),
        ];
    }
}
