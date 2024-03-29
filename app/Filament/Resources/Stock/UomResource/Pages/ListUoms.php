<?php

namespace App\Filament\Resources\Stock\UomResource\Pages;

use App\Filament\Resources\Stock\UomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUoms extends ListRecords
{
    protected static string $resource = UomResource::class;

    protected static ?string $title = 'Unit Of Measurement (UOM)';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
