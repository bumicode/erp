<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage;

class MyProfile extends TwoFactorPage
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-profile';
}
