<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Form;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class AddressContactForm
{
    /**
     * Make Address and Contact Tab
     */
    public static function schema(): Tab
    {
        return Tab::make('Address & Contact')
            ->schema([
                self::makeBillingAddressSection(),
                self::makeShippingAddressSection(),
                self::makeCompanyAddressSection(),
            ]);
    }

    /**
     * Make Billing Address Section
     */
    private static function makeBillingAddressSection(): Section
    {
        return Section::make('Billing Address')
            ->schema([
                TextInput::make('customer_address'),
                TextInput::make('contact_person'),
                TextInput::make('territory'),
            ])
            ->columns(2);
    }

    /**
     * Make Shipping Address Section
     */
    private static function makeShippingAddressSection(): Section
    {
        return Section::make('Shipping Address')
            ->schema([
                TextInput::make('shipping_address_name'),
                TextInput::make('dispatch_address_name'),
            ])
            ->columns(2);
    }

    /**
     * Make Company Address Section
     */
    private static function makeCompanyAddressSection(): Section
    {
        return Section::make('Company Address')
            ->schema([
                TextInput::make('company_address'),
            ]);
    }
}
