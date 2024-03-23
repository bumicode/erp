<?php

namespace App\Filament\Resources\Selling\CreditLimitResource\Pages;

use App\Filament\Resources\Selling\CreditLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditLimit extends EditRecord
{
    protected static string $resource = CreditLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
