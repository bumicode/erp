<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Telescope extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.pages.telescope';
    protected static ?string $navigationGroup = 'System';

    public function getTitle(): string
    {
        return '';
    }
}
