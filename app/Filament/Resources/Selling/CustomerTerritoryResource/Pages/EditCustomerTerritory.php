<?php

namespace App\Filament\Resources\Selling\CustomerTerritoryResource\Pages;

use App\Filament\Resources\Selling\CustomerTerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerTerritory extends EditRecord
{
    protected static string $resource = CustomerTerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
