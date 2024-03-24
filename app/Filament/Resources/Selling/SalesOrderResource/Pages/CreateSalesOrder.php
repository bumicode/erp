<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Pages;

use App\Filament\Resources\Selling\SalesOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesOrder extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;
}
