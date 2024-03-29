<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\ItemResource\Pages;
use App\Models\Stock\Item;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
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
                self::makeTabs(),
                self::makeMetaDataGroup(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('itemGroup.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('defaultUom.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\IconColumn::make('allow_alternative_item')
                    ->boolean(),
                Tables\Columns\IconColumn::make('maintain_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_fixed_asset')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_variant')
                    ->boolean(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('variant_base_on')
                    ->searchable(),
                Tables\Columns\IconColumn::make('allow_purchase')
                    ->boolean(),
                Tables\Columns\TextColumn::make('over_delivery_allowance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('over_billing_allowance')
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
                self::makeDashboardTab(),
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

    private static function makeDetailsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Details')
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->optionsLimit(5)
                    ->searchable(),
                Forms\Components\Select::make('item_group_id')
                    ->relationship('itemGroup', 'name')
                    ->optionsLimit(5)
                    ->searchable(),
                Forms\Components\Select::make('default_uom_id')
                    ->relationship('defaultUom', 'name')
                    ->searchable()
                    ->default(1)
                    ->optionsLimit(5),
                Forms\Components\Select::make('brand_id')
                    ->searchable()
                    ->optionsLimit(5)
                    ->relationship('brand', 'name'),
                Forms\Components\Toggle::make('status')
                    ->required(),
                Forms\Components\Toggle::make('allow_alternative_item')
                    ->required(),
                Forms\Components\Toggle::make('maintain_stock')
                    ->required(),
                Forms\Components\Toggle::make('is_fixed_asset')
                    ->required(),
                Forms\Components\Toggle::make('has_variant')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('variant_base_on')
                    ->options([
                        'item attribute' => 'Item Attribute',
                        'manufacturer' => 'Manufacturer',
                    ])
                    ->default('item attribute'),
                Forms\Components\Toggle::make('allow_purchase')
                    ->required(),
                Forms\Components\TextInput::make('over_delivery_allowance')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('over_billing_allowance')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    private static function makeDashboardTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Dashboard')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makeInventoryTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Inventory')
            ->schema([

            ])
            ->columns(2);
    }

    private static function makeVariantsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Variant')
            ->schema([

            ])
            ->columns(2);
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
            ->columns(2);
    }

    private static function makeMetaDataSection(): Section
    {
        return Forms\Components\Section::make('Meta Data')
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
}
