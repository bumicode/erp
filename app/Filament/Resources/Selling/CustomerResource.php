<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\CustomerResource\Pages;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers;
use App\Models\Selling\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_group_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('territory_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('account_manager_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('default_company_bank_account')
                    ->numeric(),
                Forms\Components\TextInput::make('customer_type')
                    ->required()
                    ->maxLength(255)
                    ->default('Individual'),
                Forms\Components\TextInput::make('gender')
                    ->required()
                    ->maxLength(255)
                    ->default('male'),
                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_sales_order')
                    ->required(),
                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_delivery_note')
                    ->required(),
                Forms\Components\Toggle::make('is_internal_customer')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_group_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('territory_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_manager_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('default_company_bank_account')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\IconColumn::make('allow_sales_invoice_creation_without_sales_order')
                    ->boolean(),
                Tables\Columns\IconColumn::make('allow_sales_invoice_creation_without_delivery_note')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_internal_customer')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
