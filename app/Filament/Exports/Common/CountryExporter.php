<?php

namespace App\Filament\Exports\Common;

use App\Models\Common\Country;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CountryExporter extends Exporter
{
    protected static ?string $model = Country::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('iso_alpha_2'),
            ExportColumn::make('iso_alpha_3'),
            ExportColumn::make('iso_numeric'),
            ExportColumn::make('calling_code'),
            ExportColumn::make('date_format'),
            ExportColumn::make('time_format'),
            ExportColumn::make('timezone'),
            ExportColumn::make('created_by'),
            ExportColumn::make('updated_by'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your country export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
