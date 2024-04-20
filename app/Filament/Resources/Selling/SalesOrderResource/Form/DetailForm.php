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
        return Tab::make(__('selling/order.tab.details.title'))
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
        return Section::make(__('selling/order.tab.details.detail.title'))
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('series')
                            ->label(__('selling/order.tab.details.detail.fields.series'))
                            ->default(SalesOrder::generateNumber())
                            ->readOnly()
                            ->unique()
                            ->maxLength(255),
                        Select::make('customer_id')
                            ->label(__('selling/order.tab.details.detail.fields.customer'))
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->optionsLimit(5)
                            ->required(),
                        Select::make('order_type')
                            ->label(__('selling/order.tab.details.detail.fields.order_type'))
                            ->options([
                                'sales' => __('selling/order.options.order_type.sales'),
                                'maintenance' => __('selling/order.options.order_type.maintenance'),
                                'shopping chart' => __('selling/order.options.order_type.shopping_chart'),
                            ])
                            ->default('sales')
                            ->required(),
                    ]),
                Group::make()
                    ->schema([
                        DateTimePicker::make('posting_date')
                            ->label(__('selling/order.tab.details.detail.fields.posting_date'))
                            ->default(Now())
                            ->disabled()
                            ->required(),
                        DateTimePicker::make('delivery_date')
                            ->label(__('selling/order.tab.details.detail.fields.delivery_date'))
                            ->closeOnDateSelection()
                            ->minDate(now())
                            ->default(Carbon::now()->addDays(3)),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('customer_purchase_order')
                            ->label(__('selling/order.tab.details.detail.fields.customer_purchase_order'))
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
        return Section::make(__('selling/order.tab.details.account.title'))
            ->schema([
                TextInput::make('cost_center')
                    ->label(__('selling/order.tab.details.account.fields.cost_center')),
                TextInput::make('project')
                    ->label(__('selling/order.tab.details.account.fields.project')),
                Group::make()
                    ->schema([
                        TextInput::make('source')
                            ->label(__('selling/order.tab.details.account.fields.source')),
                        TextInput::make('campaign')
                            ->label(__('selling/order.tab.details.account.fields.campaign')),
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
        return Section::make(__('selling/order.tab.details.currency.title'))
            ->schema([
                TextInput::make('currency')
                    ->label(__('selling/order.tab.details.currency.fields.currency')),
                Group::make()
                    ->schema([
                        TextInput::make('price_list')
                            ->label(__('selling/order.tab.details.currency.fields.price_list')),
                        Checkbox::make('ignore_pricing_rule')
                            ->label(__('selling/order.tab.details.currency.fields.ignore_pricing_rule')),
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

        return Section::make(__('selling/order.tab.details.items.title'))
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('scan_barcode')
                            ->label(__('selling/order.tab.details.items.fields.scan_barcode')),
                        Select::make('set_source_warehouse')
                            ->label(__('selling/order.tab.details.items.fields.set_source_warehouse'))
                            ->options(Warehouse::getAllDataWithoutGroup())
                            ->live(),
                    ])
                    ->columnSpan(['lg' => 4])
                    ->columns(2),
                Repeater::make('items')
                    ->label(__('selling/order.tab.details.items.title'))
                    ->schema([
                        Group::make()
                            ->schema([
                                Select::make('item_id')
                                    ->label(__('selling/order.tab.details.items.fields.item'))
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
                                    ->label(__('selling/order.tab.details.items.fields.quantity'))
                                    ->numeric()
                                    ->default(1)
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state, Get $get) {
                                        $itemId = $get('item_id');
                                        $item = $state ? Item::find($itemId) : null;
                                        self::setRates($set, $item, $state);
                                    })
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpan(['lg' => 4]),
                        Group::make()
                            ->schema([
                                TextInput::make('weight')
                                    ->label('Berat Item')
                                    ->readOnly()
                                    ->numeric()
                                    ->suffix('Kg'),
                                TextInput::make('total_weight')
                                    ->label('Berat Total')
                                    ->readOnly()
                                    ->numeric()
                                    ->suffix('Kg'),
                                TextInput::make('basic_rate')
                                    ->label(__('selling/order.tab.details.items.fields.basic_rate'))
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('Rp'),
                                TextInput::make('total_rate')
                                    ->label(__('selling/order.tab.details.items.fields.total_rate'))
                                    ->readOnly()
                                    ->numeric()
                                    ->prefix('Rp'),
                            ])
                            ->columns(4)
                            ->columnSpan(['lg' => 4]),
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
                    ->columnSpan(['lg' => 4]),
                Group::make()
                    ->schema([
                        TextInput::make('total_qty')
                            ->label(__('selling/order.tab.details.items.fields.total_qty'))
                            ->readOnly()
                            ->numeric(),
                        TextInput::make('total_net_weight')
                            ->label(__('selling/order.tab.details.items.fields.total_net_weight'))
                            ->suffix('Kg')
                            ->readOnly()
                            ->numeric(),
                        TextInput::make('total_amount')
                            ->label(__('selling/order.tab.details.items.fields.total_amount'))
                            ->prefix('Rp')
                            ->readOnly()
                            ->numeric(),
                    ])
                    ->columns(3)
                    ->columnSpan(['lg' => 4]),
            ]);
    }

    /**
     * Make Taxes Section
     */
    private static function makeTaxesSection(): Section
    {
        return Section::make(__('selling/order.tab.details.taxes.title'))
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('tax_category')
                            ->label(__('selling/order.tab.details.taxes.fields.tax_category'))
                            ->numeric(),
                        TextInput::make('shipping_rule')
                            ->label(__('selling/order.tab.details.taxes.fields.shipping_rule'))
                            ->numeric(),
                        TextInput::make('incoterm')
                            ->label(__('selling/order.tab.details.taxes.fields.incoterm'))
                            ->label('International Commercial Terms')
                            ->numeric(),
                        TextInput::make('sales_taxes_and_charges_template')
                            ->label(__('selling/order.tab.details.taxes.fields.sales_taxes_and_charges_template'))
                            ->numeric(),
                    ])
                    ->columns(3),
                Repeater::make('sales_taxes_and_charges')
                    ->label(__('selling/order.tab.details.taxes.fields.sales_taxes_and_charges'))
                    ->schema([
                        TextInput::make('type')
                            ->label(__('selling/order.tab.details.taxes.fields.type')),
                        TextInput::make('account_head')
                            ->label(__('selling/order.tab.details.taxes.fields.account_head')),
                        TextInput::make('rate')
                            ->label(__('selling/order.tab.details.taxes.fields.rate'))
                            ->prefix('Rp')
                            ->numeric(),
                        TextInput::make('amount')
                            ->label(__('selling/order.tab.details.taxes.fields.amount'))
                            ->prefix('Rp')
                            ->numeric(),
                        TextInput::make('total')
                            ->label(__('selling/order.tab.details.taxes.fields.total'))
                            ->prefix('Rp')
                            ->numeric(),
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
                                    ->label(__('selling/order.tab.details.taxes.fields.total_taxes_and_charges'))
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->numeric(),
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
        return Section::make(__('selling/order.tab.details.total.title'))
            ->schema([
                Group::make()
                    ->schema([
                        Group::make()
                            ->schema([]),
                        Group::make()
                            ->schema([
                                TextInput::make('grand_total')
                                    ->label(__('selling/order.tab.details.total.fields.grand_total'))
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->numeric(),
                                TextInput::make('rounding_adjustment')
                                    ->label(__('selling/order.tab.details.total.fields.rounding_adjustment'))
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->numeric(),
                                TextInput::make('rounded_total')
                                    ->label(__('selling/order.tab.details.total.fields.rounded_total'))
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->numeric(),
                                TextInput::make('advance_paid')
                                    ->label(__('selling/order.tab.details.total.fields.advance_paid'))
                                    ->prefix('Rp')
                                    ->readOnly()
                                    ->numeric(),
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
        return Section::make(__('selling/order.tab.details.discount.title'))
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('apply_discount_on')
                            ->label(__('selling/order.tab.details.discount.fields.apply_discount_on')),
                        TextInput::make('coupon_code')
                            ->label(__('selling/order.tab.details.discount.fields.coupon_code')),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('discount_percentage')
                            ->label(__('selling/order.tab.details.discount.fields.discount_percentage'))
                            ->numeric()
                            ->suffix('%'),
                        TextInput::make('discount_amount')
                            ->label(__('selling/order.tab.details.discount.fields.discount_amount'))
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
            $basicRate = number_format($item->standard_selling_rate, 2, '.', '');
            $totalRate = number_format($item->standard_selling_rate * $quantity, 2, '.', '');

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
        $prices = Item::find($selectedProducts->pluck('item_id'))->pluck('standard_selling_rate', 'id');

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
        $set('total_qty', $quantity);
    }
}
