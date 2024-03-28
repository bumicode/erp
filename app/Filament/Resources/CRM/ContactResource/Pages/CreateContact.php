<?php

namespace App\Filament\Resources\CRM\ContactResource\Pages;

use App\Filament\Resources\CRM\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
