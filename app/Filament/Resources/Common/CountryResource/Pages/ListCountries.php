<?php

namespace App\Filament\Resources\Common\CountryResource\Pages;

use App\Filament\Exports\Common\CountryExporter;
use App\Filament\Imports\Common\CountryImporter;
use App\Filament\Resources\Common\CountryResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ExportBulkAction;

class ListCountries extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CountryImporter::class),
            Actions\ExportAction::make()
                ->label('Export All Countries')
                ->exporter(CountryExporter::class),
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(CountryImporter::class),
            Actions\ExportAction::make()
                ->label('Export All Countries')
                ->exporter(CountryExporter::class),
        ];
    }
}
