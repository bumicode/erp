<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\ContactResource\Pages;
use App\Filament\Resources\CRM\ContactResource\RelationManagers;
use App\Models\CRM\Contact;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_primary_contact')
                            ->required(),
                        Forms\Components\Toggle::make('is_billing_contact')
                            ->required(),
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->default('Passive')
                            ->options([
                                'Open' => 'Open',
                                'Replied' => 'Replied',
                                'Passive' => 'Passive',
                            ])
                            ->default('Open'),
                        Forms\Components\TextInput::make('middle_name')
                            ->maxLength(255),
                        Forms\Components\Select::make('salutation_id')
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->default(null)
                            ->relationship('salutation', 'name'),
                        Forms\Components\TextInput::make('last_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('designation')
                            ->maxLength(255),
                        Forms\Components\Select::make('user_id')
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->default(null)
                            ->relationship('user', 'name'),
                        Forms\Components\Select::make('gender')
                            ->required()
                            ->default('Male')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                        Forms\Components\Select::make('address_id')
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->default(null)
                            ->relationship('address', 'address_title'),
                        Forms\Components\TextInput::make('company_name')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->label('Customer')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address_id')
                    ->label('Address')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('salutation_id')
                    ->label('Salutation')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_id')
                    ->label('User')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_primary_contact')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_billing_contact')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Replied' => 'warning',
                        'Open' => 'success',
                        'Passive' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
