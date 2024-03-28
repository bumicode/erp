<?php

namespace App\Filament\Resources\Common\TimezoneResource\Pages;

use App\Filament\Resources\Common\TimezoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimezone extends EditRecord
{
    protected static string $resource = TimezoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
