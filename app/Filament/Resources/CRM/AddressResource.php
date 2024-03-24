<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\AddressResource\Pages;
use App\Filament\Resources\CRM\AddressResource\RelationManagers;
use App\Models\CRM\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tax_category')
                    ->numeric(),
                Forms\Components\Toggle::make('is_preferred_billing_address')
                    ->required(),
                Forms\Components\Toggle::make('is_preferred_shipping_address')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->required(),
                Forms\Components\TextInput::make('address_title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_type')
                    ->required()
                    ->maxLength(255)
                    ->default('Billing'),
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
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_address')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('fax')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tax_category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_preferred_billing_address')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_preferred_shipping_address')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('address_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_line_one')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_line_two')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city_town')
                    ->searchable(),
                Tables\Columns\TextColumn::make('county')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state_province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fax')
                    ->searchable(),
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
}
