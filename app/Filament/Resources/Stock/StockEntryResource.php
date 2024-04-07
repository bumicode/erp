<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\StockEntryResource\Pages;
use App\Helpers\UniqueNumberGenerator;
use App\Models\Stock\StockEntry;
use App\Models\Stock\Warehouse;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
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
        $series = UniqueNumberGenerator::generateStockEntryNumber(StockEntry::class, 'series');

        return Forms\Components\Tabs\Tab::make('Details')
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('series')
                            ->default($series)
                            ->required()
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
        return Forms\Components\Tabs\Tab::make('Items')
            ->schema([
                Repeater::make('items')
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
                        Select::make('item_id')
                            ->relationship('items', 'name')
                            ->preload()
                            ->optionsLimit(5)
                            ->searchable()
                            ->required()
                            ->live(),
                        TextInput::make('quantity')
                            ->minValue(0)
                            ->numeric()
                            ->required(),
                        TextInput::make('basic_rate')
                            ->prefix('Rp')
                            ->minValue(0)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                    ])
                    ->minItems(1)
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('total_outgoing')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('total_incoming')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('total_value')
                            ->required()
                            ->numeric(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 4]),
//                    ->hidden(fn (?StockEntry $record) => $record == null),
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
}
