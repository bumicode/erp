<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\CustomerTerritoryResource\Pages;
use App\Filament\Resources\Selling\CustomerTerritoryResource\RelationManagers;
use App\Models\Selling\CustomerTerritory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerTerritoryResource extends Resource
{
    protected static ?string $model = CustomerTerritory::class;
    protected static ?string $navigationGroup = 'Selling';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCustomerTerritories::route('/'),
            'create' => Pages\CreateCustomerTerritory::route('/create'),
            'view' => Pages\ViewCustomerTerritory::route('/{record}'),
            'edit' => Pages\EditCustomerTerritory::route('/{record}/edit'),
        ];
    }
}
