<?php

namespace App\Filament\Resources\Selling\TerritoryResource\Pages;

use App\Filament\Resources\Selling\TerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerritory extends EditRecord
{
    protected static string $resource = TerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
