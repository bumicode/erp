<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\TerritoryResource\Pages;
use App\Filament\Resources\Selling\TerritoryResource\RelationManagers;
use App\Models\Selling\Territory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TerritoryResource extends Resource
{
    protected static ?string $model = Territory::class;

    protected static ?string $navigationGroup = 'Selling';
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->default(1)
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->relationship('parent', 'name'),
                Forms\Components\TextInput::make('name')
                    ->string(),
                Forms\Components\Select::make('territory_manager_id')
                    ->relationship('manager', 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('manager.name')
                    ->numeric(),
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
            'index' => Pages\ListTerritories::route('/'),
            'create' => Pages\CreateTerritory::route('/create'),
            'view' => Pages\ViewTerritory::route('/{record}'),
            'edit' => Pages\EditTerritory::route('/{record}/edit'),
        ];
    }
}
