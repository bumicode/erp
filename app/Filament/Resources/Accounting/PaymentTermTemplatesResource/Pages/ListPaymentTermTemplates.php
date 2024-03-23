<?php

namespace App\Filament\Resources\Accounting\PaymentTermTemplatesResource\Pages;

use App\Filament\Resources\Accounting\PaymentTermTemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentTermTemplates extends ListRecords
{
    protected static string $resource = PaymentTermTemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
