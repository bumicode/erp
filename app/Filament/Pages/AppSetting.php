<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class AppSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')
                    ->label('Site Name')
                    ->required(),
                Toggle::make('site_active')
                    ->label('Site Active')
                    ->default(true),
                //                Repeater::make('links')
                //                    ->schema([
                //                        TextInput::make('label')->required(),
                //                        TextInput::make('url')
                //                            ->url()
                //                            ->required(),
                //                    ]),
            ]);
    }
}
