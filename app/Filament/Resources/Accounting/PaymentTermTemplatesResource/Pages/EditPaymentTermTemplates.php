<?php

namespace App\Filament\Resources\Accounting\PaymentTermTemplatesResource\Pages;

use App\Filament\Resources\Accounting\PaymentTermTemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTermTemplates extends EditRecord
{
    protected static string $resource = PaymentTermTemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
