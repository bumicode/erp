<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\Stock\StockEntryTypeResource\Pages;
use App\Filament\Resources\Stock\StockEntryTypeResource\RelationManagers;
use App\Models\Stock\StockEntryType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockEntryTypeResource extends Resource
{
    protected static ?string $model = StockEntryType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('purpose')
                    ->options([
                        'material issue' => 'Material Issue',
                        'material receipt' => 'Material Receipt',
                        'material transfer' => 'Material Transfer',
                        'material transfer for manufacture' => 'Material Transfer for Manufacture',
                        'material consumption for manufacture' => 'Material Consumption for Manufacture',
                        'manufacture' => 'Manufacture',
                        'repack' => 'Repack',
                        'send to subcontractor' => 'Send to Subcontractor',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purpose')
                    ->searchable(),
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
            'index' => Pages\ListStockEntryTypes::route('/'),
            'create' => Pages\CreateStockEntryType::route('/create'),
            'edit' => Pages\EditStockEntryType::route('/{record}/edit'),
        ];
    }
}
