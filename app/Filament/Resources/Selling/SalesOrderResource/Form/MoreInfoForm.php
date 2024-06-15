<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Form;

use App\Enums\Stock\SalesOrderStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class MoreInfoForm
{
    /**
     * Make More Info Tab
     */
    public static function schema(): Tab
    {
        return Tab::make('More Info')
            ->schema([
                self::makeStatusSection(),
                self::makeCommissionSection(),
                self::makeSalesTeamSection(),
                self::makeAutoRepeatSection(),
                self::makeAdditionalInfoSection(),
            ]);
    }

    /**
     * Make Status Section
     */
    private static function makeStatusSection(): Section
    {
        return Section::make('Status')
            ->schema([
                Select::make('status')
                    ->default('draft')
                    ->disabled()
                    ->options(SalesOrderStatus::class),
            ])
            ->collapsed()
            ->columns(2);
    }

    /**
     * Make Commission Section
     */
    private static function makeCommissionSection(): Section
    {
        return Section::make('Commission')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('sales_partner'),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('amount_eligible_for_commission'),
                        TextInput::make('commission_rate'),
                        TextInput::make('total_commission'),
                    ]),
            ])
            ->collapsed()
            ->columns(2);
    }

    /**
     * Make Sales Team Section
     */
    private static function makeSalesTeamSection(): Section
    {
        return Section::make('Sales Team')
            ->schema([
                Repeater::make('sales_team')
                    ->schema([
                        TextInput::make('sales_person'),
                        TextInput::make('contribution'),
                        TextInput::make('contribution_to_net_total'),
                        TextInput::make('commission_rate'),
                        TextInput::make('incentive'),
                    ])
                    ->columns(5),
            ])
            ->collapsed();
    }

    /**
     * Make Auto Repeate Section
     */
    private static function makeAutoRepeatSection(): Section
    {
        return Section::make('Auto Repeat')
            ->schema([
                TextInput::make('from_date'),
                TextInput::make('auto_repeat'),
                TextInput::make('to_date'),
            ])
            ->columns(2)
            ->collapsed();
    }

    /**
     * Make Additional Info Sections
     */
    private static function makeAdditionalInfoSection(): Section
    {
        return Section::make('Additional Info')
            ->schema([
                Checkbox::make('is_internal_customer'),
            ])
            ->columns(2)
            ->collapsed();
    }
}
