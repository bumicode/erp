<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Pulse extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static string $view = 'filament.pages.pulse';
    protected static ?string $navigationGroup = 'System';

    public function getTitle(): string
    {
        return '';
    }
}
