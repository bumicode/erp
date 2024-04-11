<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\ItemPriceResource\Pages;
use App\Models\Stock\ItemPrice;
use App\Models\Stock\ItemPriceList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemPriceResource extends Resource
{
    protected static ?string $model = ItemPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::itemSection(),
                self::priceListSection(),
            ]);
    }

    protected static function itemSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make()
            ->schema([
                self::itemGroup(),
                self::itemDetailsGroup(),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    protected static function itemGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'name')
                    ->live()
                    ->searchable()
                    ->required()
                    ->hidden(fn (?ItemPrice $record) => $record != null),
                Forms\Components\Select::make('uom_id')
                    ->label('UOM')
                    ->relationship('uom', 'name'),
                Forms\Components\TextInput::make('packing_unit')
                    ->helperText('Quantity that must be bought or sold per UOM')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }

    protected static function itemDetailsGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\TextInput::make('item_name')
                    ->disabled(),
                Forms\Components\Textarea::make('item_description')
                    ->disabled(),
            ]);
    }

    protected static function priceListSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Price List')
            ->schema([
                self::priceListGroup(),
                self::additionalInfoGroup(),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    protected static function priceListGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('price_list_id')
                            ->searchable()
                            ->optionsLimit(5)
                            ->default(1)
                            ->preload()
                            ->relationship('priceList', 'name')
                            ->required()
                            ->live(),
                        Forms\Components\Select::make('batch_id')
                            ->searchable()
                            ->optionsLimit(5)
                            ->preload()
                            ->label('Batch No')
                            ->relationship('batch', 'id'),
                    ]),
                Forms\Components\Group::make()
                    ->schema([

                        Forms\Components\Checkbox::make('is_selling')
                            ->default(true)
                            ->disabled()
                            ->hidden(fn ($get) => (bool) ! ItemPriceList::where('id', $get('price_list_id'))
                                ->value('is_selling')),

                        Forms\Components\Checkbox::make('is_buying')
                            ->default(true)
                            ->disabled()
                            ->hidden(fn ($get) => (bool) ! ItemPriceList::where('id', $get('price_list_id'))
                                ->value('is_buying')),
                    ]),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    protected static function additionalInfoGroup(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'code')
                    ->searchable()
                    ->optionsLimit(5)
                    ->preload()
                    ->default(13),
                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('valid_from')
                    ->default(Now())
                    ->required(),
                Forms\Components\DatePicker::make('valid_upto'),
                Forms\Components\TextInput::make('lead_time_in_days')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->columnSpan(['lg' => 4]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uom.abbreviation')
                    ->numeric(),
                Tables\Columns\TextColumn::make('packing_unit')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('priceList.name')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_buying')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_selling')
                    ->boolean(),
                Tables\Columns\TextColumn::make('batch.id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('currency.code')
                    ->numeric(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('valid_upto')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lead_time_in_days')
                    ->numeric()
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
            'index' => Pages\ListItemPrices::route('/'),
            'create' => Pages\CreateItemPrice::route('/create'),
            'edit' => Pages\EditItemPrice::route('/{record}/edit'),
        ];
    }
}
