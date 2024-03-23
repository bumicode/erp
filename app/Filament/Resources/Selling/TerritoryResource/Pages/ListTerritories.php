<?php

namespace App\Filament\Resources\Selling\TerritoryResource\Pages;

use App\Filament\Resources\Selling\TerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerritories extends ListRecords
{
    protected static string $resource = TerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
