<?php

namespace App\Filament\Resources\Accounting\SalesInvoiceResource\Pages;

use App\Filament\Resources\Accounting\SalesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSalesInvoice extends ViewRecord
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
