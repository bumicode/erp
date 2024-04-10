<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\StockEntryResource\Pages;
use App\Helpers\UniqueNumberGenerator;
use App\Models\Stock\Item;
use App\Models\Stock\StockEntry;
use App\Models\Stock\Warehouse;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockEntryResource extends Resource
{
    protected static ?string $model = StockEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()
                    ->tabs([
                        self::detailsTab(),
                        self::itemsTab(),
                        self::additionalCostTab(),
                        self::supplierInfo(),
                        self::accountingDimensionsTab(),
                        self::otherInfoTab(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),
            ])->columns(3);
    }

    private static function detailsTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Details')
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('series')
                            ->label('Series')
                            ->default('STE-YYYY-')
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\Select::make('stock_entry_type_id')
                            ->label('Stock Entry Type')
                            ->relationship('stockEntryType', 'name')
                            ->optionsLimit(10)
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\DateTimePicker::make('posting_at')
                            ->default(Now()),
                        Forms\Components\Toggle::make('is_inspection_required')
                            ->required(),
                    ]),
            ]);
    }

    private static function itemsTab(): Forms\Components\Tabs\Tab
    {
        $items = Item::get();

        return Forms\Components\Tabs\Tab::make('Items')
            ->schema([
                Repeater::make('items')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Select::make('source_warehouse_id')
                                    ->label('Source Warehouse')
                                    ->searchable()
                                    ->options(Warehouse::getAllDataWithoutGroup()),
                                Select::make('target_warehouse_id')
                                    ->label('Target Warehouse')
                                    ->searchable()
                                    ->options(Warehouse::getAllDataWithoutGroup())
                                    ->required(),
                            ])
                            ->columns(2),
                        Forms\Components\Group::make()
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
                                    ->label('Basic Rate')
                                    ->prefix('Rp')
                                    ->readOnly(),
                                TextInput::make('total_rate')
                                    ->label('Total')
                                    ->prefix('Rp')
                                    ->readOnly(),
                            ])
                            ->columns(4),
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

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('total_outgoing')
                            ->label('Total Outgoing Value (Consumption)')
                            ->readOnly()
                            ->prefix('Rp')
                            ->default(0)
                            ->numeric(),
                        Forms\Components\TextInput::make('total_incoming')
                            ->label('Total Incoming Value (Receipt)')
                            ->prefix('Rp')
                            ->default(0)
                            ->readOnly()
                            ->numeric(),
                        Forms\Components\TextInput::make('total_value')
                            ->label('Total Value Difference (Incoming - Outgoing)')
                            ->readOnly()
                            ->prefix('Rp')
                            ->numeric(),
                    ])
                    ->columns(3)
                    ->columnSpan(['lg' => 4]),
            ]);
    }

    private static function additionalCostTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Additional Cost')
            ->schema([
                Repeater::make('additional_costs')
                    ->schema([
                        Select::make('expense_account_id'),
                        TextInput::make('description')
                            ->required(),
                        TextInput::make('amount')
                            ->required()
                            ->numeric(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),
                Forms\Components\TextInput::make('total_additional_cost')
                    ->required()
                    ->numeric(),
                //                    ->hidden(fn (?StockEntry $record) => $record == null),
            ]);
    }

    private static function supplierInfo(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Supplier Info')
            ->schema([
                // Define schema for this tab
            ]);
    }

    private static function accountingDimensionsTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Accounting Dimensions')
            ->schema([
                // Define schema for this tab
            ]);
    }

    private static function otherInfoTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Other Info')
            ->schema([
                // Define schema for this tab
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stockEntryType.name')
                    ->label('Stock Entry Type'),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('series')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stockEntryType.purpose')
                    ->label('Purpose')
                    ->badge(),
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
            'index' => Pages\ListStockEntries::route('/'),
            'create' => Pages\CreateStockEntry::route('/create'),
            'view' => Pages\ViewStockEntry::route('/{record}'),
            'edit' => Pages\EditStockEntry::route('/{record}/edit'),
        ];
    }

    // This function updates totals based on the selected products and quantities
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

        // Update the state with the new values
        $set('total_incoming', number_format($subtotal, 2, '.', ''));
        $set('total_value', number_format($subtotal - $get('total_outgoing'), 2, '.', ''));
    }

    public static function setRates(Set $set, ?Item $item, $quantity)
    {
        if ($item && $quantity) {
            $basicRate = number_format($item->standard_buying_rate, 2, ',', '.');
            $totalRate = number_format($item->standard_buying_rate * $quantity, 2, ',', '.');
            $set('basic_rate', $basicRate);
            $set('total_rate', $totalRate);
        } else {
            $set('basic_rate', null);
            $set('total_rate', null);
        }
    }
}
