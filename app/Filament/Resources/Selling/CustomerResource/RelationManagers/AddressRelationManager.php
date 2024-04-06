<?php

namespace App\Filament\Resources\Selling\CustomerResource\RelationManagers;

use App\Filament\Resources\CRM\AddressResource;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        AddressResource::makeGroup(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Title')
            ->columns([
                Tables\Columns\TextColumn::make('address_type')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('address_title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('address_line_one')
                    ->label('Address'),
                Tables\Columns\TextColumn::make('email_address')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('fax')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordTitleAttribute('address_title'),
                Tables\Actions\CreateAction::make(),
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
