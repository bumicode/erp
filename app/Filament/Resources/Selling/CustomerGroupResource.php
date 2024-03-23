<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\CustomerGroupResource\Pages;
use App\Filament\Resources\Selling\CustomerGroupResource\RelationManagers;
use App\Models\Selling\CustomerGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerGroupResource extends Resource
{
    protected static ?string $model = CustomerGroup::class;
    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('parent_id')
                    ->numeric(),
                Forms\Components\TextInput::make('default_price_list_id')
                    ->numeric(),
                Forms\Components\TextInput::make('default_payment_terms_template')
                    ->numeric(),
                Forms\Components\Toggle::make('is_group')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('default_price_list_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('default_payment_terms_template')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_group')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ListCustomerGroups::route('/'),
            'create' => Pages\CreateCustomerGroup::route('/create'),
            'view' => Pages\ViewCustomerGroup::route('/{record}'),
            'edit' => Pages\EditCustomerGroup::route('/{record}/edit'),
        ];
    }
}
