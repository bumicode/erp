<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\TargetResource\Pages;
use App\Filament\Resources\Selling\TargetResource\RelationManagers;
use App\Models\Selling\Target;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TargetResource extends Resource
{
    protected static ?string $model = Target::class;

    protected static ?string $navigationGroup = 'Selling';
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_group_target_id')
                    ->numeric(),
                Forms\Components\TextInput::make('fiscal_year_id')
                    ->numeric(),
                Forms\Components\TextInput::make('target_qty')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('target_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('target_distribution_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item_group_target_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fiscal_year_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_distribution_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListTargets::route('/'),
            'create' => Pages\CreateTarget::route('/create'),
            'view' => Pages\ViewTarget::route('/{record}'),
            'edit' => Pages\EditTarget::route('/{record}/edit'),
        ];
    }
}
