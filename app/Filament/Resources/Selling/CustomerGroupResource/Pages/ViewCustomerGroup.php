<?php

namespace App\Filament\Resources\Selling\CustomerGroupResource\Pages;

use App\Filament\Resources\Selling\CustomerGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerGroup extends ViewRecord
{
    protected static string $resource = CustomerGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
