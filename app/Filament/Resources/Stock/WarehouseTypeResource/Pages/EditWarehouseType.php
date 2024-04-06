<?php

namespace App\Filament\Resources\Stock\WarehouseTypeResource\Pages;

use App\Filament\Resources\Stock\WarehouseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarehouseType extends EditRecord
{
    protected static string $resource = WarehouseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
