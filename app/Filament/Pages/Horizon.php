<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Horizon extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static string $view = 'filament.pages.horizon';

    protected static ?string $navigationGroup = 'System';

    public function getTitle(): string
    {
        return '';
    }

}
