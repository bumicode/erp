<?php

namespace App\Filament\Resources\Common\TimezoneResource\Pages;

use App\Filament\Resources\Common\TimezoneResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListTimezones extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = TimezoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
