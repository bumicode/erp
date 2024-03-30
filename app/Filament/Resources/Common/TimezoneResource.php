<?php

namespace App\Filament\Resources\Common;

use App\Filament\Resources\Common\TimezoneResource\Pages;
use App\Filament\Resources\Common\TimezoneResource\RelationManagers;
use App\Models\Common\Timezone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimezoneResource extends Resource
{
    protected static ?string $model = Timezone::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('offset')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('offset_hours')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('offset_minutes')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('offset'),
                Tables\Columns\TextColumn::make('offset_hours'),
                Tables\Columns\TextColumn::make('offset_minutes'),
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
            'index' => Pages\ListTimezones::route('/'),
            'create' => Pages\CreateTimezone::route('/create'),
            'edit' => Pages\EditTimezone::route('/{record}/edit'),
        ];
    }
}
