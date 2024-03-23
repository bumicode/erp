<?php

namespace App\Filament\Resources\Accounting\PaymentTermTemplatesResource\Pages;

use App\Filament\Resources\Accounting\PaymentTermTemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentTermTemplates extends ViewRecord
{
    protected static string $resource = PaymentTermTemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
