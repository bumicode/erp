<?php

namespace App\Filament\Resources\Selling\TerritoryResource\Pages;

use App\Filament\Resources\Selling\TerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTerritory extends ViewRecord
{
    protected static string $resource = TerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
