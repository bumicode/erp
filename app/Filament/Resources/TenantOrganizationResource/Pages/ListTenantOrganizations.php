<?php

namespace App\Filament\Resources\TenantOrganizationResource\Pages;

use App\Filament\Resources\TenantOrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTenantOrganizations extends ListRecords
{
    protected static string $resource = TenantOrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
