<?php

namespace App\Filament\Resources\Selling\CustomerTerritoryResource\Pages;

use App\Filament\Resources\Selling\CustomerTerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerTerritories extends ListRecords
{
    protected static string $resource = CustomerTerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
