<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\AddressResource\Pages;
use App\Models\CRM\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $slug = 'crm/addresses';

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        self::makeGroup(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'view' => Pages\ViewAddress::route('/{record}'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }

    public static function makeGroup(string $defaultAddressType = 'Billing'): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->default(true)
                    ->hidden(fn (?Address $record) => $record === null),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_preferred_billing_address')
                            ->label('Is Preferred Billing Addresses')
                            ->required(),

                        Forms\Components\Toggle::make('is_preferred_shipping_address')
                            ->label('Is Preferred Shipping Addresses')
                            ->required(),

                        Forms\Components\TextInput::make('address_title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('address_type')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default($defaultAddressType)
                            ->options([
                                'Billing' => 'Billing',
                                'Shipping' => 'Shipping',
                                'Office' => 'Office',
                                'Personal' => 'Personal',
                                'Plant' => 'Plant',
                                'Postal' => 'Postal',
                                'Shop' => 'Shop',
                                'Subsidiary' => 'Subsidiary',
                                'Warehouse' => 'Warehouse',
                                'Current' => 'Current',
                                'Permanent' => 'Permanent',
                                'Other' => 'Other',
                            ]),

                        Forms\Components\TextInput::make('address_line_one')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address_line_two')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('city_town')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('county')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('state_province')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('country')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('postal_code')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email_address')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('fax')
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }
}
