<?php

namespace App\Filament\Resources\Stock\ItemResource\Pages;

use App\Filament\Resources\Stock\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewItem extends ViewRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
