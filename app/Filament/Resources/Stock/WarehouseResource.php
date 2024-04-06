<?php

namespace App\Filament\Resources\Stock;

use App\Filament\Resources\CRM\AddressResource;
use App\Filament\Resources\CRM\ContactResource;
use App\Filament\Resources\Stock\WarehouseResource\Pages;
use App\Models\Stock\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Warehouse Detail')
                    ->schema([
                        self::makeName(),
                        self::makeDetails(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_group')
                    ->boolean(),
                Tables\Columns\TextColumn::make('parent.name')
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }

    public static function makeName(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Warehouse Name')
                    ->required()
                    ->maxLength(255),
            ])->columns(2);
    }

    public static function makeDetails(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('is_group')
                    ->required(),
                Forms\Components\Select::make('warehouse_type_id')
                    ->relationship('warehouseType', 'name')
                    ->createOptionForm([
                        WarehouseTypeResource::makeGroup(),
                    ])
                    ->editOptionForm([
                        WarehouseTypeResource::makeGroup(),
                    ])
                    ->optionsLimit(5)
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('parent_id')
                    ->optionsLimit(5)
                    ->searchable()
                    ->preload()
                    ->relationship('parent', 'name'),
                Forms\Components\Select::make('in_transit_warehouse_id')
                    ->optionsLimit(5)
                    ->searchable()
                    ->preload()
                    ->relationship('inTransitWarehouse', 'name'),
                Forms\Components\Select::make('account_id')
                    ->optionsLimit(5)
                    ->searchable()
                    ->preload()
                    ->relationship('account', 'name'),
                Forms\Components\Select::make('address_id')
                    ->relationship('addresses', 'address_title')
                    ->editOptionForm([
                        AddressResource::makeGroup(),
                    ])
                    ->hidden(fn (?Warehouse $record) => $record->address_id == null),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contacts', 'full_name')
                    ->editOptionForm([
                        ContactResource::makeGroup(),
                    ])
                    ->hidden(fn (?Warehouse $record) => $record->contact_id == null),
                Forms\Components\Select::make('address_id')
                    ->relationship('addresses', 'address_title')
                    ->createOptionForm([
                        AddressResource::makeGroup('Warehouse'),
                    ])
                    ->hidden(fn (?Warehouse $record) => $record->address_id != null),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contacts', 'full_name')
                    ->createOptionForm([
                        ContactResource::makeGroup(),
                    ])
                    ->hidden(fn (?Warehouse $record) => $record->contact_id != null),
            ])->columns(2);
    }
}
