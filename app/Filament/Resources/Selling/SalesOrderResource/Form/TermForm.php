<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Form;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class TermForm
{
    /**
     * Make Terms Tab
     */
    public static function schema(): Tab
    {
        return Tab::make('Terms')
            ->schema([
                self::makePaymentTermsSection(),
                self::makeTermsAndConditionsSection(),
            ]);
    }

    /**
     * Make Payment Terms Section
     */
    private static function makePaymentTermsSection(): Section
    {
        return Section::make('Payment Terms')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('payment_terms_template'),
                    ])
                    ->columns(2),
                Repeater::make('payment_schedule')
                    ->schema([
                        TextInput::make('payment_terms'),
                        TextInput::make('description'),
                        TextInput::make('due_date'),
                        TextInput::make('invoice_portion'),
                        TextInput::make('payment_amount'),
                    ])
                    ->columns(5),
            ]);
    }

    /**
     * Make Terms and Conditions Section
     */
    private static function makeTermsAndConditionsSection(): Section
    {
        return Section::make('Terms & Conditions')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('terms'),
                    ])
                    ->columns(2),
                RichEditor::make('details'),
            ]);
    }
}
