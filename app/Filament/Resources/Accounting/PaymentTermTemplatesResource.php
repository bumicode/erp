<?php

namespace App\Filament\Resources\Accounting;

use App\Filament\Resources\Accounting\PaymentTermTemplatesResource\Pages;
use App\Filament\Resources\Accounting\PaymentTermTemplatesResource\RelationManagers;
use App\Models\Accounting\PaymentTermTemplates;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentTermTemplatesResource extends Resource
{
    protected static ?string $model = PaymentTermTemplates::class;
    protected static ?string $navigationGroup = 'Accounting';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPaymentTermTemplates::route('/'),
            'create' => Pages\CreatePaymentTermTemplates::route('/create'),
            'view' => Pages\ViewPaymentTermTemplates::route('/{record}'),
            'edit' => Pages\EditPaymentTermTemplates::route('/{record}/edit'),
        ];
    }
}
