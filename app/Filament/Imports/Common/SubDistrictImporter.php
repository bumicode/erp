<?php

namespace App\Filament\Imports\Common;

use App\Models\Common\SubDistrict;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class SubDistrictImporter extends Importer
{
    protected static ?string $model = SubDistrict::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('city_code')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('sub_district_code')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('postal_code')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('geometry'),
            ImportColumn::make('latitude')
                ->rules(['max:255']),
            ImportColumn::make('longitude')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?SubDistrict
    {
        // return SubDistrict::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new SubDistrict();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your sub district import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
