<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\StockEntryResource\Pages;
use App\Filament\Resources\Stock\StockEntryResource\RelationManagers;
use App\Models\Stock\StockEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockEntryResource extends Resource
{
    protected static ?string $model = StockEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('series')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stock_entry_type_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_inspection_required')
                    ->required(),
                Forms\Components\DateTimePicker::make('posting_at')
                    ->required(),
                Forms\Components\TextInput::make('items')
                    ->required(),
                Forms\Components\TextInput::make('total_outgoing')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_incoming')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_value')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('additional_costs')
                    ->required(),
                Forms\Components\TextInput::make('total_additional_cost')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('series')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_entry_type_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_inspection_required')
                    ->boolean(),
                Tables\Columns\TextColumn::make('posting_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_outgoing')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_incoming')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_additional_cost')
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
            'edit' => Pages\EditStockEntry::route('/{record}/edit'),
        ];
    }
}
