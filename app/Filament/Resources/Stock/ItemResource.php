<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\ItemResource\Pages;
use App\Models\Stock\Item;
use App\Models\Stock\UnitOfMeasure;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
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
        $code = self::generateCode();

        return Tabs\Tab::make('Details')
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Item Template')
                            ->relationship('parent', 'name')
                            ->hidden(fn (?Item $record) => $record === null),
                        Forms\Components\Select::make('brand_id')
                            ->searchable()
                            ->optionsLimit(5)
                            ->relationship('brand', 'name'),
                        Forms\Components\TextInput::make('code')
                            ->default($code)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255),
                        Forms\Components\Select::make('item_group_id')
                            ->relationship('itemGroup', 'name')
                            ->searchable()
                            ->optionsLimit(5)
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('default_uom_id')
                            ->relationship('defaultUom', 'abbreviation')
                            ->default(1),
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
                        Forms\Components\Toggle::make('is_fixed_asset')
                            ->required(),
                        Forms\Components\TextInput::make('over_delivery_allowance')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('over_billing_allowance')
                            ->required()
                            ->numeric()
                            ->default(0),
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
                            ->label('Default Material Request Type')
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

    private static function generateCode()
    {
        $latestItem = Item::latest()->first();
        if ($latestItem) {
            $seriesNumber = intval(substr($latestItem->code, 3)) + 1;
        } else {
            $seriesNumber = 1;
        }

        return 'ITM'.str_pad($seriesNumber, 4, '0', STR_PAD_LEFT);
    }
}
