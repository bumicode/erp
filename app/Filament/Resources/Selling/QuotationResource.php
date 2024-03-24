<?php

namespace App\Filament\Resources\Selling;

use App\Filament\Resources\Selling\QuotationResource\Pages;
use App\Filament\Resources\Selling\QuotationResource\RelationManagers;
use App\Models\Selling\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tax_category_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('sales_tax_charge_template')
                    ->numeric(),
                Forms\Components\TextInput::make('series')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('Draft'),
                Forms\Components\DateTimePicker::make('posting_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('valid_upto')
                    ->required(),
                Forms\Components\TextInput::make('order_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_net_weight')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_tax_charge')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('grand_total')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rounding_adjustment')
                    ->numeric(),
                Forms\Components\TextInput::make('rounded_total')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tax_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales_tax_charge_template')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('series')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('posting_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_upto')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_net_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_tax_charge')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rounding_adjustment')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rounded_total')
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
