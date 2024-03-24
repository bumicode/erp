<?php

namespace App\Filament\Resources\Selling\TargetResource\Pages;

use App\Filament\Resources\Selling\TargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTarget extends ViewRecord
{
    protected static string $resource = TargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
