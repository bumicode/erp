<?php

namespace App\Filament\Resources\Common\SubDistrictResource\Pages;

use App\Filament\Resources\Common\SubDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubDistrict extends EditRecord
{
    protected static string $resource = SubDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
