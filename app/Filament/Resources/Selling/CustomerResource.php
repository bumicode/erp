<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\CustomerResource\Pages;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\ContactRelationManager;
use App\Models\Selling\Customer;
use App\Models\Selling\CustomerGroup;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::makeTabs(),
                self::makeMetaDataGroup(),
            ])
            ->columns(3);
    }

    private static function makeTabs(): Tabs
    {
        return Tabs::make('Tabs')
            ->tabs([
                self::makeDetailsTab(),
                self::makeContactAddressTab(),
                self::makeTaxTab(),
                self::makeAccountingTab(),
                self::makeSalesTeamTab(),
                self::makeSettingsTab(),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    private static function makeDetailsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Details')
            ->icon('heroicon-m-information-circle')
            ->schema([

                Forms\Components\Select::make('salutation_id')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->relationship('salutation', 'name'),

                Forms\Components\Select::make('territory_id')
                    ->relationship('territory', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Select::make('parent_id')
                            ->default(1)
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->relationship('parent', 'name'),
                        Forms\Components\TextInput::make('name')
                            ->string(),
                        Forms\Components\Select::make('territory_manager_id')
                            ->relationship('manager', 'name')
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10),
                    ])
                    ->optionsLimit(10),

                Forms\Components\TextInput::make('name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('gender')
                    ->required()
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),

                Forms\Components\Select::make('customer_type')
                    ->required()
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('from_lead')
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('customer_group_id')
                    ->label('Customer Group')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->optionsLimit(10)
                    ->createOptionForm([
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->default(1)
                            ->preload(),
                        Forms\Components\Select::make('default_price_list_id')
                            ->relationship('defaultPriceList', 'name'),
                        Forms\Components\TextInput::make('default_payment_terms_template')
                            ->numeric(),
                        Forms\Components\Toggle::make('is_group')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Select::make('from_opportunity')
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('account_manager_id')
                    ->label('Account Manager')
                    ->searchable()
                    ->optionsLimit(10)
                    ->relationship('manager', 'name'),

                Forms\Components\Section::make('Default')
                    ->schema([

                        Forms\Components\TextInput::make('default_price_list')
                            ->label('Default Price List')
                            ->numeric(),

                        Forms\Components\TextInput::make('currency_id')
                            ->label('Billing Currency')
                            ->numeric(),

                        Forms\Components\TextInput::make('default_company_bank_account')
                            ->label('Default Company Bank Account')
                            ->numeric(),

                    ])->columns(2),

                Section::make('Internal Customer')
                    ->description('Marks that the consumer is an internal customer')
                    ->schema([

                        Forms\Components\Toggle::make('is_internal_customer')
                            ->label('Mark as Internal Customer')
                            ->required(),

                    ])
                    ->collapsed(),

                Section::make('More Information')
                    ->schema([

                        Forms\Components\TextInput::make('market_segment_id')
                            ->label('Market Segment')
                            ->numeric(),

                        Forms\Components\TextInput::make('industry_id')
                            ->label('Industry')
                            ->numeric(),

                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->numeric(),

                        RichEditor::make('content'),
                    ])
                    ->collapsed(),
            ]);
    }

    private static function makeContactAddressTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Contact & Address')
            ->icon('heroicon-m-identification')
            ->schema([

                Section::make('Primary Address and Contact')
                    ->description('Select, to make the customer searchable with these fields')
                    ->schema([

                        Select::make('primary_address_id')
                            ->helperText('Reselect, if the chosen address is edited after save')
                            ->relationship(name: 'primaryAddress', titleAttribute: 'address_title')
                            ->optionsLimit(10)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('tax_category')
                                    ->numeric(),
                                Forms\Components\Toggle::make('is_preferred_billing_address')
                                    ->disabled()
                                    ->default(true)
                                    ->required(),
                                Forms\Components\Toggle::make('is_preferred_shipping_address')
                                    ->disabled()
                                    ->default(true)
                                    ->required(),
                                Forms\Components\Toggle::make('status')
                                    ->default(true)
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
                            ])
                            ->createOptionModalHeading('Create New Address')
                            ->searchable(),

                        Select::make('primary_contact_id')
                            ->helperText('Reselect, if the chosen contact is edited after save')
                            ->relationship(
                                name: 'contacts', titleAttribute: 'first_name')
                            ->getOptionLabelFromRecordUsing(
                                fn (Model $record) => "{$record->first_name} {$record->last_name}"
                            )
                            ->searchable(['first_name', 'last_name'])
                            ->createOptionForm([
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('middle_name')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('last_name')
                                    ->maxLength(255),
                                Forms\Components\Select::make('address_id')
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(10)
                                    ->default(null)
                                    ->relationship('address', 'address_title'),
                                Forms\Components\Select::make('salutation_id')
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(10)
                                    ->default(null)
                                    ->relationship('salutation', 'name'),
                                Forms\Components\Select::make('user_id')
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(10)
                                    ->default(null)
                                    ->relationship('user', 'name'),
                                Forms\Components\Toggle::make('is_primary_contact')
                                    ->default(true)
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Toggle::make('is_billing_contact')
                                    ->default(true)
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->required()
                                    ->default('Passive')
                                    ->options([
                                        'Open' => 'Open',
                                        'Replied' => 'Replied',
                                        'Passive' => 'Passive',
                                    ]),
                                Forms\Components\TextInput::make('designation')
                                    ->maxLength(255),
                                Forms\Components\Select::make('gender')
                                    ->required()
                                    ->default('Male')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ]),
                                Forms\Components\TextInput::make('company_name')
                                    ->maxLength(255),
                            ]),

                    ])->columns(2),
            ]);
    }

    private static function makeTaxTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Tax')
            ->icon('heroicon-m-receipt-percent')
            ->schema([

                Forms\Components\TextInput::make('tax_id')
                    ->label('Tax ID'),

                Forms\Components\TextInput::make('tax_category_id')
                    ->label('Tax Category')
                    ->numeric(),

                Forms\Components\TextInput::make('tax_withholding_category_id')
                    ->label('Tax Withholding Category')
                    ->numeric(),

            ])
            ->columns(2);
    }

    private static function makeAccountingTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Accounting')
            ->icon('heroicon-m-clipboard-document-list')
            ->schema([
                Section::make('Credit Limit and Payment Terms')
                    ->schema([

                        Forms\Components\TextInput::make('default_payment_terms_template')
                            ->label('Default Payment Terms Template')
                            ->numeric(),

                    ])->columns(2),
            ]);
    }

    private static function makeSalesTeamTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Sales Team')
            ->icon('heroicon-m-user')
            ->schema([

                Repeater::make('Sales Team')
                    ->schema([
                        TextInput::make('sales_person_id')
                            ->label('Sales Person')
                            ->live(onBlur: true)
                            ->required(),
                        TextInput::make('contribution')
                            ->label('Contribution (%)')
                            ->required(),
                        TextInput::make('commission_rate')
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpan(['lg' => 4])
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),

                Forms\Components\TextInput::make('sales_partner')
                    ->label('Sales Partner')
                    ->numeric(),

                Forms\Components\TextInput::make('commission_rate')
                    ->label('Commission Rate')
                    ->numeric(),
            ])
            ->columns(2);
    }

    private static function makeSettingsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Settings')
            ->icon('heroicon-m-cog-6-tooth')
            ->schema([
                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_sales_order')
                    ->label('Allow sales invoice creation without Sales Order')
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->default(true),

                Forms\Components\Toggle::make('allow_sales_invoice_creation_without_delivery_note')
                    ->label('Allow sales invoice creation without Delivery Note')
                    ->required(),
            ])
            ->columns(2);
    }

    private static function makeMetaDataGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                self::makeMetaDataSection(),
            ])
            ->columnSpan(['lg' => 4])
            ->columns(2)
            ->hidden(fn (?Customer $record) => $record === null);
    }

    private static function makeMetaDataSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Meta Data')
            ->schema([
                Forms\Components\Placeholder::make('created_at')
                    ->label('Created at')
                    ->content(fn (Customer $record): ?string => $record->created_at?->diffForHumans()),

                Forms\Components\Placeholder::make('updated_at')
                    ->label('Last modified at')
                    ->content(fn (Customer $record): ?string => $record->updated_at?->diffForHumans()),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4])
            ->hidden(fn (?Customer $record) => $record === null);
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
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_internal_customer')->label('Internal Customer')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
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
