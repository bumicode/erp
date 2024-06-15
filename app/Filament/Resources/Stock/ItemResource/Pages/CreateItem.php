<?php

namespace App\Filament\Resources\Stock\ItemResource\Pages;

use App\Filament\Resources\Stock\ItemResource;
use Filament\Resources\Pages\CreateRecord;
use ZeeshanTariq\FilamentAttachmate\Core\HandleAttachments;

class CreateItem extends CreateRecord
{
    use HandleAttachments;

    protected static string $resource = ItemResource::class;
}
