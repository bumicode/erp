<?php

namespace App\Filament\Resources\Selling\SalesPersonResource\Pages;

use App\Filament\Resources\Selling\SalesPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSalesPerson extends ViewRecord
{
    protected static string $resource = SalesPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
