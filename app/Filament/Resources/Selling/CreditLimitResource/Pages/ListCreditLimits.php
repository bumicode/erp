<?php

namespace App\Filament\Resources\Selling\CreditLimitResource\Pages;

use App\Filament\Resources\Selling\CreditLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditLimits extends ListRecords
{
    protected static string $resource = CreditLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
