<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\CRM\AddressResource;
use App\Filament\Resources\CRM\ContactResource;
use App\Filament\Resources\Selling\CustomerResource\Pages;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\ContactRelationManager;
use App\Filament\Resources\Selling\CustomerResource\RelationManagers\SalesRelationManager;
use App\Models\Selling\Customer;
use App\Models\Selling\SalesPerson;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getLabel(): string
    {
        return __('selling/customers.customer');
    }

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
        return Tabs\Tab::make(__('selling/customers.tab.details'))
            ->schema([
                Forms\Components\Select::make('salutation_id')
                    ->label(__('selling/customers.field.detail.salutation'))
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->relationship('salutation', 'name')
                    ->default(1),

                Forms\Components\Select::make('territory_id')
                    ->relationship('territory', 'name')
                    ->label(__('selling/customers.field.detail.territory'))
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
                    ->label(__('selling/customers.field.detail.name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('gender')
                    ->label(__('selling/customers.field.detail.gender'))
                    ->required()
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),

                Forms\Components\Select::make('customer_type')
                    ->label(__('selling/customers.field.detail.customer_type'))
                    ->required()
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('from_lead')
                    ->label(__('selling/customers.field.detail.from_lead'))
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('customer_group_id')
                    ->label(__('selling/customers.field.detail.customer_group'))
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
                    ->label(__('selling/customers.field.detail.from_opportunity'))
                    ->options([
                        'Individual' => 'Individual',
                        'Corporate' => 'Corporate',
                    ]),

                Forms\Components\Select::make('account_manager_id')
                    ->label(__('selling/customers.field.detail.customer_manager'))
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

                Section::make(__('selling/customers.field.detail.internal_customer.title'))
                    ->description(__('selling/customers.field.detail.internal_customer.description'))
                    ->schema([

                        Forms\Components\Toggle::make('is_internal_customer')
                            ->label(__('selling/customers.field.detail.internal_customer.action'))
                            ->required(),

                    ])
                    ->collapsed(),

                Section::make(__('selling/customers.field.detail.more_information.title'))
                    ->schema([

                        Forms\Components\TextInput::make('market_segment_id')
                            ->label(__('selling/customers.field.detail.more_information.field.market_segment'))
                            ->numeric(),

                        Forms\Components\TextInput::make('industry_id')
                            ->label(__('selling/customers.field.detail.more_information.field.industry'))
                            ->numeric(),

                        Forms\Components\TextInput::make('website')
                            ->label(__('selling/customers.field.detail.more_information.field.website'))
                            ->numeric(),

                        RichEditor::make('content')
                            ->label(__('selling/customers.field.detail.more_information.field.content')),
                    ])
                    ->collapsed(),
            ]);
    }

    private static function makeContactAddressTab(): Tabs\Tab
    {
        return Tabs\Tab::make(__('selling/customers.tab.contact_address'))
            ->schema([
                Section::make(__('selling/customers.field.contact_address.title'))
                    ->description(__('selling/customers.field.contact_address.description'))
                    ->schema([

                        Select::make('primary_address_id')
                            ->label(__('selling/customers.field.contact_address.field.address'))
                            ->helperText(__('selling/customers.field.contact_address.field.address_hint'))
                            ->relationship(name: 'primaryAddress', titleAttribute: 'address_title')
                            ->optionsLimit(10)
                            ->createOptionForm([
                                AddressResource::makeGroup(),
                            ])
                            ->preload()
                            ->searchable()
                            ->hidden(fn (?Customer $record) => $record != null),

                        Select::make('primary_contact_id')
                            ->label(__('selling/customers.field.contact_address.field.contact'))
                            ->helperText(__('selling/customers.field.contact_address.field.contact_hint'))
                            ->relationship(
                                name: 'primaryContact', titleAttribute: 'full_name')
                            ->optionsLimit(10)
                            ->createOptionForm([
                                ContactResource::makeGroup(),
                            ])
                            ->preload()
                            ->searchable(['full_name'])
                            ->hidden(fn (?Customer $record) => $record != null),

                        Select::make('primary_address_id')
                            ->helperText('Reselect, if the chosen address is edited after save')
                            ->relationship(name: 'primaryAddress', titleAttribute: 'address_title')
                            ->optionsLimit(10)
                            ->options(fn (Customer $record): ?array => Customer::with('addresses')->find($record->id)
                                ->addresses->pluck('address_title', 'id')->toArray())
                            ->default(null)
                            ->searchable()
                            ->hidden(fn (?Customer $record) => $record === null),

                        Select::make('primary_contact_id')
                            ->helperText('Reselect, if the chosen contact is edited after save')
                            ->relationship(
                                name: 'primaryContact', titleAttribute: 'full_name')
                            ->optionsLimit(10)
                            ->options(fn (Customer $record): ?array => Customer::with('contacts')->find($record->id)
                                ->contacts->pluck('full_name', 'id')->toArray())
                            ->searchable(['full_name'])
                            ->default(null)
                            ->hidden(fn (?Customer $record) => $record === null),

                    ])->columns(2),
            ]);
    }

    private static function makeTaxTab(): Tabs\Tab
    {
        return Tabs\Tab::make(__('selling/customers.tab.tax'))
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
        return Tabs\Tab::make(__('selling/customers.tab.accounting'))
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
        return Tabs\Tab::make(__('selling/customers.tab.sales_team'))
            ->schema([

                Repeater::make('Sales Team')
                    ->relationship('salesPeople')
                    ->schema([
                        Select::make('sales_person_id')
                            ->label('Sales Person')
                            ->searchable()
                            ->options(SalesPerson::all()->pluck('name', 'id'))
                            ->optionsLimit(5),
                        TextInput::make('contribution')
                            ->label('Contribution (%)')
                            ->minValue(0)
                            ->maxValue(100)
                            ->numeric(),
                        TextInput::make('contribution_to_net_total')
                            ->label('Contribution to Net Total')
                            ->prefix('Rp')
                            ->disabled(),
                        TextInput::make('commission_rate')
                            ->label('Commission Rate')
                            ->numeric(),
                        TextInput::make('incentives')
                            ->label('Incentives')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                    ])
                    ->defaultItems(0)
                    ->columns(3)
                    ->columnSpan(['lg' => 4])
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation(),
                    ),

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
        return Tabs\Tab::make(__('selling/customers.tab.settings'))
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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, '.now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Order from '.Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until '.Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->deferFilters()
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
            SalesRelationManager::class,
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
