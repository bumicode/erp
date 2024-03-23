<?php

namespace App\Filament\Resources\Selling\CustomerResource\Pages;

use App\Filament\Resources\Selling\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
