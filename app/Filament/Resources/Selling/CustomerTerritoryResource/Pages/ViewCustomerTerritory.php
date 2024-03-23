<?php

namespace App\Filament\Resources\Selling\CustomerTerritoryResource\Pages;

use App\Filament\Resources\Selling\CustomerTerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerTerritory extends ViewRecord
{
    protected static string $resource = CustomerTerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
