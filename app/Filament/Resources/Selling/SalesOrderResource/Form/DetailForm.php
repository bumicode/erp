<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Form;

use App\Exceptions\MissingAttributeException;
use App\Models\Selling\SalesOrder;
use App\Models\Stock\Item;
use App\Models\Stock\Warehouse;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;

class DetailForm
{
    /**
     * Make Details Tab
     *
     * @throws MissingAttributeException
     */
    public static function schema(): Tab
    {
        return Tab::make('Details')
            ->schema([
                self::makeDetailsSection(),
                self::makeAccountDimensionsSection(),
                self::makeCurrencyAndPriceListSection(),
                self::makeItemsSection(),
                self::makeTaxesSection(),
                self::makeTotalsSection(),
                self::makeAdditionalDiscountSection(),
            ]);
    }

    /**
     * Make Detail Section
     *
     * @throws MissingAttributeException
     */
    private static function makeDetailsSection(): Section
    {
        return Section::make('Details')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('series')
                            ->default(SalesOrder::generateNumber())
                            ->readOnly()
                            ->unique()
                            ->maxLength(255),
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->optionsLimit(5)
                            ->required(),
                        Select::make('order_type')
                            ->options([
                                'sales' => 'Sales',
                                'maintenance' => 'Maintenance',
                                'shopping chart' => 'Shopping Chart',
                            ])
                            ->default('sales')
                            ->required(),
                    ]),
                Group::make()
                    ->schema([
                        DateTimePicker::make('posting_date')
                            ->default(Now())
                            ->disabled()
                            ->required(),
                        DateTimePicker::make('delivery_date')
                            ->closeOnDateSelection()
                            ->minDate(now())
                            ->default(Carbon::now()->addDays(3)),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('customer_purchase_order')
                            ->maxLength(255),
                    ]),
            ])
            ->columns(3);
    }

    /**
     * Make Account Dimensions Section
     */
    private static function makeAccountDimensionsSection(): Section
    {
        return Section::make('Account Dimensions')
            ->schema([
                TextInput::make('cost_center'),
                TextInput::make('project'),
                Group::make()
                    ->schema([
                        TextInput::make('source'),
                        TextInput::make('campaign'),
                    ]),
            ])
            ->collapsed()
            ->columns(3);
    }

    /**
     * Make Currency and Price List Section
     */
    private static function makeCurrencyAndPriceListSection(): Section
    {
        return Section::make('Currency and Price List')
            ->schema([
                TextInput::make('currency'),
                Group::make()
                    ->schema([
                        TextInput::make('price_list'),
                        Checkbox::make('ignore_pricing_rule'),
                    ]),
            ])
            ->collapsed()
            ->columns(2);
    }

    /**
     * Make Item Section
     */
    private static function makeItemsSection(): Section
    {
        $items = Item::get();

        return Section::make('Items')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('scan_barcode'),
                        Select::make('set_source_warehouse')
                            ->options(Warehouse::getAllDataWithoutGroup()),
                    ])
                    ->columnSpan(['lg' => 4])
                    ->columns(2),
                Repeater::make('items')
                    ->schema([
                        Select::make('item_id')
                            ->relationship('items', 'name')
                            ->options(
                                $items->mapWithKeys(function ($item) {
                                    return [$item->id => $item->name];
                                })
                            )
                            ->disableOptionWhen(function ($value, $state, Get $get) {
                                return collect($get('../*.item_id'))
                                    ->reject(fn ($id) => $id == $state)
                                    ->filter()
                                    ->contains($value);
                            })
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state, Get $get) {
                                $item = $state ? Item::find($state) : null;
                                $quantity = $get('quantity');
                                self::setRates($set, $item, $quantity);
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->integer()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state, Get $get) {
                                $itemId = $get('item_id');
                                $item = $state ? Item::find($itemId) : null;
                                self::setRates($set, $item, $state);
                            })
                            ->required(),
                        TextInput::make('basic_rate')
                            ->integer()
                            ->prefix('Rp'),
                        TextInput::make('total_rate')
                            ->integer()
                            ->prefix('Rp'),
                    ])
                    // Repeatable field is live so that it will trigger the state update on each change
                    ->live()
                    // After adding a new row, we need to update the totals
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    })
                    // After deleting a row, we need to update the totals
                    ->deleteAction(
                        fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                    )
                    // Disable reordering
                    ->reorderable(false)
                    ->columns(4)
                    ->columnSpan(['lg' => 4]),
                Group::make()
                    ->schema([
                        TextInput::make('total_quantity')
                            ->readOnly()
                            ->integer(),
                        TextInput::make('total_amount')
                            ->prefix('Rp')
                            ->readOnly()
                            ->integer(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),
            ]);
    }

    /**
     * Make Taxes Section
     */
    private static function makeTaxesSection(): Section
    {
        return Section::make('Taxes')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('tax_category')
                            ->numeric(),
                        TextInput::make('shipping_rule')
                            ->numeric(),
                        TextInput::make('incoterm')
                            ->label('International Commercial Terms')
                            ->numeric(),
                        TextInput::make('sales_taxes_and_charges_template')
                            ->numeric(),
                    ])
                    ->columns(3),
                Repeater::make('sales_taxes_and_charges')
                    ->label('Sales Taxes and Charges')
                    ->schema([
                        TextInput::make('type'),
                        TextInput::make('account_head'),
                        TextInput::make('rate')
                            ->prefix('Rp')
                            ->integer(),
                        TextInput::make('amount')
                            ->prefix('Rp')
                            ->integer(),
                        TextInput::make('total')
                            ->prefix('Rp')
                            ->integer(),
                    ])
                    ->defaultItems(0)
                    ->columns(5),
                Group::make()
                    ->schema([
                        Group::make()
                            ->schema([]),
                        Group::make()
                            ->schema([
                                TextInput::make('total_taxes_and_charges')
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->integer(),
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Make Total Section
     */
    private static function makeTotalsSection(): Section
    {
        return Section::make('Totals')
            ->schema([
                Group::make()
                    ->schema([
                        Group::make()
                            ->schema([]),
                        Group::make()
                            ->schema([
                                TextInput::make('grand_total')
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->integer(),
                                TextInput::make('rounding_adjustment')
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->integer(),
                                TextInput::make('rounded_total')
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->integer(),
                                TextInput::make('advance_paid')
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->integer(),
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Make Additional Discount Section
     */
    private static function makeAdditionalDiscountSection(): Section
    {
        return Section::make('Additional Discount')
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('apply_discount_on')
                            ->label('Apply Additional Discount On'),
                        TextInput::make('coupon_code'),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('discount_percentage')
                            ->label('Additional Discount Percentage')
                            ->numeric()
                            ->suffix('%'),
                        TextInput::make('discount_amount')
                            ->label('Additional Discount Amount')
                            ->prefix('Rp')
                            ->numeric(),
                    ]),
            ])
            ->collapsed()
            ->columns(2);
    }

    public static function setRates(Set $set, ?Item $item, $quantity)
    {
        if ($item && $quantity) {
            $basicRate = number_format($item->standard_buying_rate, 2, '.', '');
            $totalRate = number_format($item->standard_buying_rate * $quantity, 2, '.', '');

            $set('basic_rate', $basicRate);
            $set('total_rate', $totalRate);
        } else {
            $set('basic_rate', null);
            $set('total_rate', null);
        }
    }

    private static function updateTotals(Get $get, Set $set): void
    {
        // Retrieve all selected products and remove empty rows
        $selectedProducts = collect($get('items'))->filter(fn ($item) => ! empty($item['item_id']) && ! empty($item['quantity']));
        // Retrieve prices for all selected products
        $prices = Item::find($selectedProducts->pluck('item_id'))->pluck('standard_buying_rate', 'id');

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['item_id']] * $product['quantity']);
        }, 0);

        // Calculate quantity
        $quantity = $selectedProducts->reduce(function ($quantity, $product) {
            return $quantity + $product['quantity'];
        }, 0);

        // Update the state with the new values
        $set('total_amount', number_format($subtotal, 2, '.', ''));
        $set('total_quantity', $quantity);
    }
}
