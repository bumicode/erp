<?php

namespace App\Filament\Resources\Stock\ItemResource\Pages;

use App\Filament\Resources\Stock\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;
}
