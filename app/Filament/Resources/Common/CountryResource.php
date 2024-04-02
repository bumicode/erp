<?php

namespace App\Filament\Resources\Common;

use App\Filament\Exports\Common\CountryExporter;
use App\Filament\Resources\Common\CountryResource\Pages;
use App\Models\Common\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('iso_alpha_2')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('iso_alpha_3')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('iso_numeric')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('calling_code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('date_format')
                    ->maxLength(255),
                Forms\Components\TextInput::make('time_format')
                    ->maxLength(255),
                Forms\Components\TextInput::make('timezone')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('iso_alpha_2')
                    ->label('ISO Alpha 2')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('iso_alpha_3')
                    ->label('ISO Alpha 3')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('iso_numeric')
                    ->label('ISO Num')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('calling_code')
                    ->searchable(isIndividual: true),
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
                    ExportBulkAction::make()
                        ->exporter(CountryExporter::class),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

            ])
            ->headerActions([

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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
