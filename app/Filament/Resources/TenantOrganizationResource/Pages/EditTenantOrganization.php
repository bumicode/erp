<?php

namespace App\Filament\Resources\TenantOrganizationResource\Pages;

use App\Filament\Resources\TenantOrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenantOrganization extends EditRecord
{
    protected static string $resource = TenantOrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
