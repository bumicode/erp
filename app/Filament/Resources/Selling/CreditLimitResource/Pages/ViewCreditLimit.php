<?php

namespace App\Filament\Resources\Selling\CreditLimitResource\Pages;

use App\Filament\Resources\Selling\CreditLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCreditLimit extends ViewRecord
{
    protected static string $resource = CreditLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
