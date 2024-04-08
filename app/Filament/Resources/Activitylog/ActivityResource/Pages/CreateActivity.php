<?php

namespace App\Filament\Resources\Activitylog\ActivityResource\Pages;

use App\Filament\Resources\Activitylog\ActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;
}
