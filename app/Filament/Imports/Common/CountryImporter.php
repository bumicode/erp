<?php

namespace App\Filament\Imports\Common;

use App\Models\Common\Country;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CountryImporter extends Importer
{
    protected static ?string $model = Country::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('iso_alpha_2')
                ->requiredMapping()
                ->rules(['required', 'max:2']),
            ImportColumn::make('iso_alpha_3')
                ->requiredMapping()
                ->rules(['required', 'max:3']),
            ImportColumn::make('iso_numeric')
                ->requiredMapping()
                ->rules(['required', 'max:3']),
            ImportColumn::make('calling_code')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('date_format')
                ->rules(['max:255']),
            ImportColumn::make('time_format')
                ->rules(['max:255']),
            ImportColumn::make('timezone')
                ->rules(['max:255']),
            ImportColumn::make('created_by')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('updated_by')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Country
    {
        // return Country::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Country();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your country import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
