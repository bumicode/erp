<?php

namespace App\Filament\Resources\Selling\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'salesPeople';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Sales Person')
            ->columns([
                Tables\Columns\TextColumn::make('salesPerson.name')
                    ->label('Sales Name'),
                Tables\Columns\TextColumn::make('contribution')
                    ->suffix(' %'),
                Tables\Columns\TextColumn::make('commission_rate')
                    ->label('Commission Rate')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('contribution_to_net_total')
                    ->label('Contribution to Net Total')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('incentives')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
