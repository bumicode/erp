<?php

namespace App\Filament\Resources\Selling;

use App\Exceptions\MissingAttributeException;
use App\Filament\Resources\Selling\SalesOrderResource\Form\AddressContactForm;
use App\Filament\Resources\Selling\SalesOrderResource\Form\DetailForm;
use App\Filament\Resources\Selling\SalesOrderResource\Form\MoreInfoForm;
use App\Filament\Resources\Selling\SalesOrderResource\Form\TermForm;
use App\Filament\Resources\Selling\SalesOrderResource\Pages;
use App\Models\Selling\SalesOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;

    protected static ?string $navigationGroup = 'Selling';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    /**
     * @throws MissingAttributeException
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()
                    ->tabs([
                        DetailForm::schema(),
                        AddressContactForm::schema(),
                        TermForm::schema(),
                        MoreInfoForm::schema(),
                    ])
                    ->columnSpan(['lg' => 4]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_address_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_contact_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_shipping_address_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales_tax_charge_template')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_terms_template_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('series')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('billed_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('posting_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_date')
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
            'index' => Pages\ListSalesOrders::route('/'),
            'create' => Pages\CreateSalesOrder::route('/create'),
            'view' => Pages\ViewSalesOrder::route('/{record}'),
            'edit' => Pages\EditSalesOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
