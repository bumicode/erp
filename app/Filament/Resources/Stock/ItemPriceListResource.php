<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\ItemPriceListResource\Pages;
use App\Models\Stock\ItemPriceList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemPriceListResource extends Resource
{
    protected static ?string $model = ItemPriceList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'stock/price-lists';

    protected static ?string $label = 'Price List';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('currency_id')
                            ->relationship('currency', 'code')
                            ->required(),
                        Forms\Components\Toggle::make('is_buying')
                            ->required(),
                        Forms\Components\Toggle::make('is_selling')
                            ->required(),
                        Forms\Components\Toggle::make('is_price_not_uom_dependent')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.code')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_buying')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_selling')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
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
            'index' => Pages\ListItemPriceLists::route('/'),
            'create' => Pages\CreateItemPriceList::route('/create'),
            'edit' => Pages\EditItemPriceList::route('/{record}/edit'),
        ];
    }
}
