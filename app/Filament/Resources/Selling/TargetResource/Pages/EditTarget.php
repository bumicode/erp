<?php

namespace App\Filament\Resources\Selling\TargetResource\Pages;

use App\Filament\Resources\Selling\TargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarget extends EditRecord
{
    protected static string $resource = TargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
