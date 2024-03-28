<?php

namespace App\Filament\Resources\Common\CountryResource\Pages;

use App\Filament\Resources\Common\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
