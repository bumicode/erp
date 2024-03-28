<?php

namespace App\Filament\Resources\Selling\CustomerResource\RelationManagers;

use App\Models\CRM\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->default(true)
                    ->hidden(fn (?Address $record) => $record === null),

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

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Title')
            ->columns([
                Tables\Columns\TextColumn::make('address_type')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('address_title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('address_line_one')
                    ->label('Address'),
                Tables\Columns\TextColumn::make('email_address')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('fax')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordTitleAttribute('address_title'),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
