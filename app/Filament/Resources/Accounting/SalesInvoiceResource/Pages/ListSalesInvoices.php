<?php

namespace App\Filament\Resources\Accounting\SalesInvoiceResource\Pages;

use App\Filament\Resources\Accounting\SalesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesInvoices extends ListRecords
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
