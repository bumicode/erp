<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\CustomerResource\Pages;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\ContactRelationManager;
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

                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('gender')
                            ->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),

                        Forms\Components\Section::make('Sales Settings')
                            ->schema([

                                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_sales_order')
                                    ->label('Allow sales invoice creation without Sales Order')
                                    ->required(),

                                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_delivery_note')
                                    ->label('Allow sales invoice creation without Delivery Note')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Accounting Settings')
                            ->schema([

                                Forms\Components\TextInput::make('default_company_bank_account')
                                    ->numeric(),
                            ]),

                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),
                //                    ->columnSpan(['lg' => fn (?Customer $record) => $record === null ? 3 : 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Customer Info')
                            ->schema([

                                Forms\Components\Toggle::make('status')
                                    ->label('Status')
                                    ->default(true),

                                Forms\Components\Select::make('customer_type')
                                    ->required()
                                    ->options([
                                        'Individual' => 'Individual',
                                        'Corporate' => 'Corporate',
                                    ]),

                                Forms\Components\Toggle::make('is_internal_customer')
                                    ->label('Internal Customer')
                                    ->helperText('Marks that the consumer is an internal customer')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Associations')
                            ->schema([
                                Forms\Components\Select::make('customer_group_id')
                                    ->relationship('group', 'name')
                                    ->required(),

                                Forms\Components\Select::make('territory_id')
                                    ->relationship('territory', 'name')
                                    ->required(),

                                Forms\Components\Select::make('account_manager_id')
                                    ->relationship('manager', 'name')
                                    ->required(),
                            ])
                            ->columnSpan(['lg' => 1]),

                        Forms\Components\Section::make('Meta Data')
                            ->schema([

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Customer $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (Customer $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->hidden(fn (?Customer $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_internal_customer')->label('Internal Customer')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('territory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_manager_id')->label('Account Manager')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('default_company_bank_account')->label('Default Bank Account')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('customer_type')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_sales_invoice_creation_without_sales_order')
                    ->label('Allow Invoice Without SO')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_sales_invoice_creation_without_delivery_note')
                    ->label('Allow Invoice Without DO')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('addresses')->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class,
            ContactRelationManager::class,
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
