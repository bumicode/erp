<?php

namespace App\Filament\Resources\Stock\UomResource\Pages;

use App\Filament\Resources\Stock\UomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUom extends EditRecord
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
