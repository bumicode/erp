<?php

namespace App\Filament\Resources\Stock;

use App\Exceptions\MissingAttributeException;
use App\Filament\Resources\Stock\ItemResource\Pages;
use App\Models\Stock\Item;
use App\Models\Stock\ItemGroup;
use App\Models\Stock\UnitOfMeasure;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::makeNotification(),
                self::makeTabs(),
                self::makeMetaDataGroup(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Item Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('itemGroup.name')
                    ->label('Item Group')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    private static function makeTabs(): Tabs
    {
        return Tabs::make('Tabs')
            ->tabs([
                self::makeDetailsTab(),
                self::makeInventoryTab(),
                self::makeVariantsTab(),
                self::makeAccountingTab(),
                self::makePurchasingTab(),
                self::makeSalesTab(),
                self::makeTaxTab(),
                self::makeQualityTab(),
                self::makeManufacturingTab(),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    private static function makeDetailsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Details')
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Item Template')
                            ->relationship('parent', 'name')
                            ->hidden(function (?Item $item): bool {
                                return $item->parent_id === null || $item !== null;
                            }),
                        Forms\Components\Select::make('brand_id')
                            ->searchable()
                            ->optionsLimit(5)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->relationship('brand', 'name'),
                        Forms\Components\TextInput::make('code')
                            ->helperText(__('Leave it blank if you want it to be automatic'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Item Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('item_group_id')
                            ->relationship('itemGroup', 'name')
                            ->searchable()
                            ->options(ItemGroup::getAllDataWithoutGroup())
                            ->optionsLimit(5)
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('default_uom_id')
                            ->label('Default UOM')
                            ->default(1)
                            ->helperText(__('Smaller UOM for this item'))
                            ->relationship('defaultUom', 'abbreviation')
                            ->searchable()
                            ->optionsLimit(5)
                            ->live(),
                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Toggle::make('active')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('allow_alternative_item')
                            ->required(),
                        Forms\Components\Toggle::make('maintain_stock')
                            ->default(true)
                            ->live()
                            ->required(),
                        Forms\Components\Toggle::make('has_variant')
                            ->helperText('If this item  has variants, then it cannot be selected in sales orders etc.')
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('over_delivery_allowance')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->hidden(fn (?Item $record) => $record === null),
                        Forms\Components\TextInput::make('over_billing_allowance')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->hidden(fn (?Item $record) => $record === null),
                        Forms\Components\TextInput::make('opening_stock')
                            ->numeric()
                            ->default(1)
                            ->hidden(function (Get $get, ?Item $record): bool {
                                return ! $get('maintain_stock') || $record !== null;
                            }),
                        Forms\Components\TextInput::make('standard_buying_rate')
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->label('Standard Buying Rate')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->hidden(fn (?Item $record) => $record != null),
                        Forms\Components\TextInput::make('standard_selling_rate')
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->label('Standard Selling Rate')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->hidden(fn (?Item $record) => $record != null),
                        Forms\Components\Toggle::make('is_fixed_asset')
                            ->required(),
                    ]),

                Section::make('Description')
                    ->schema([
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
            ]);
    }

    private static function makeInventoryTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Inventory')
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->relationship('itemInventory')
                            ->schema([

                                Forms\Components\TextInput::make('shelf_life')
                                    ->label('Shelf Life In Days')
                                    ->minValue(0)
                                    ->numeric(),

                                Forms\Components\DatePicker::make('end_of_life')
                                    ->label('End of Life')
                                    ->default('31-12-2099'),

                                Forms\Components\Select::make('default_material_request_type')
                                    ->label('Default Material Request Type')
                                    ->options([
                                        'purchase' => 'Purchase',
                                        'material transfer' => 'Material Transfer',
                                        'material issue' => 'Material Issue',
                                        'manufacture' => 'Manufacture',
                                        'customer provided' => 'Customer Provided',
                                    ]),

                                Forms\Components\Select::make('valuation_method')
                                    ->label('Valuation Method')
                                    ->options([
                                        'fifo' => 'FIFO',
                                        'moving average' => 'Moving Average',
                                        'lifo' => 'LIFO',
                                    ]),
                            ]),

                        Forms\Components\Group::make()
                            ->relationship('itemInventory')
                            ->schema([

                                Forms\Components\TextInput::make('warranty_period')
                                    ->label('Warranty Period (in days)')
                                    ->minValue(0)
                                    ->numeric(),

                                Forms\Components\TextInput::make('weight_per_unit')
                                    ->label('Weight Per Unit')
                                    ->numeric(),

                                Forms\Components\Select::make('weight_uom_id')
                                    ->options(UnitOfMeasure::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->optionsLimit(5)
                                    ->label('Weight Per Unit'),

                                Forms\Components\Toggle::make('allow_negative_stock')
                                    ->label('Allow Negative Stock'),
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),
                Section::make('Barcodes')
                    ->schema([
                        Forms\Components\Repeater::make('barcodes')
                            ->label('Barcodes')
                            ->relationship('itemBarcodes')
                            ->schema([
                                Forms\Components\TextInput::make('barcode')
                                    ->unique(),
                                Forms\Components\Select::make('barcode_type')
                                    ->options([
                                        'EAN-13' => 'EAN-13',
                                        'EAN-8' => 'EAN-8',
                                        'UPC-A' => 'UPC-A',
                                        'UPC-E' => 'UPC-E',
                                        'JAN' => 'JAN',
                                        'ISBN' => 'ISBN',
                                        'ISSN' => 'ISSN',
                                    ]),
                                Forms\Components\Select::make('uom_id')
                                    ->label('UOM')
                                    ->relationship('uom', 'abbreviation')
                                    ->searchable()
                                    ->optionsLimit(5)
                                    ->preload()
                                    ->disableOptionWhen(function ($value, $state, Get $get) {
                                        return collect($get('../*.uom_id'))
                                            ->reject(fn ($id) => $id == $state)
                                            ->filter()
                                            ->contains($value);
                                    })
                                    ->live(),
                            ])
                            ->defaultItems(0)
                            ->columns(3)
                            ->columnSpan(['lg' => 4]),
                    ])
                    ->collapsed(),
                Section::make('Units of Measure')
                    ->schema([
                        Forms\Components\Repeater::make('uoms')
                            ->label('UOMs')
                            ->relationship('itemUomConversion')
                            ->schema([
                                Forms\Components\Select::make('uom_id')
                                    ->label('UOM')
                                    ->relationship('uom', 'abbreviation')
                                    ->searchable()
                                    ->optionsLimit(5)
                                    ->preload()
                                    ->disableOptionWhen(function ($value, $state, Get $get) {
                                        return collect($get('../*.uom_id'))
                                            ->reject(fn ($id) => $id == $state)
                                            ->filter()
                                            ->contains($value);
                                    })
                                    ->live(),
                                Forms\Components\TextInput::make('conversion_rate')
                                    ->numeric()
                                    ->default(1),
                            ])
                            ->defaultItems(0)
                            ->columns(2)
                            ->columnSpan(['lg' => 4]),
                    ])
                    ->collapsed(),
            ])
            ->hidden(fn (Get $get): bool => ! $get('maintain_stock'));
    }

    private static function makeVariantsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Variant')
            ->schema([
                Forms\Components\Select::make('variant_base_on')
                    ->options([
                        'item attribute' => 'Item Attribute',
                        'manufacturer' => 'Manufacturer',
                    ])
                    ->default('item attribute'),

            ])
            ->columns(2)
            ->hidden(fn (Get $get): bool => ! $get('has_variant'));
    }

    private static function makeAccountingTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Accounting')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makePurchasingTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Purchasing')
            ->schema([

                Forms\Components\Toggle::make('allow_purchase')
                    ->default(true)
                    ->required(),
            ])
            ->columns(2);
    }

    private static function makeSalesTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Sales')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makeTaxTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Tax')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makeQualityTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Quality')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makeManufacturingTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Manufacturing')
            ->schema([

            ])
            ->columns(2)
            ->hidden(fn (Get $get): bool => ! $get('maintain_stock'));
    }

    private static function makeMetaDataGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                self::makeMetaDataSection(),
            ])
            ->columnSpan(['lg' => 4])
            ->columns(2)
            ->hidden(fn (?Item $record) => $record === null);

    }

    private static function makeMetaDataSection(): Section
    {
        return Forms\Components\Section::make()
            ->schema([
                Forms\Components\Placeholder::make('created_at')
                    ->label('Created at')
                    ->content(fn (Item $record): ?string => $record->created_at?->diffForHumans()),

                Forms\Components\Placeholder::make('updated_at')
                    ->label('Last modified at')
                    ->content(fn (Item $record): ?string => $record->updated_at?->diffForHumans()),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4])
            ->hidden(fn (?Item $record) => $record === null);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    private static function makeNotification(): Section
    {
        return Forms\Components\Section::make()
            ->schema([
                Forms\Components\Placeholder::make('status')
                    ->label('Template')
                    ->content(fn (Item $record): ?string => 'This Item is a Variant of '.$record->parent->name.' (Template)'),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4])
            ->hidden(fn (?Item $record) => $record === null || $record->parent_id === null);
    }
}
