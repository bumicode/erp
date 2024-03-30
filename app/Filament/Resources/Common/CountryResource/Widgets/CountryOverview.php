<?php

namespace App\Filament\Resources\Common\CountryResource\Widgets;

use App\Filament\Resources\Common\CountryResource\Pages\ListCountries;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountryOverview extends BaseWidget
{
    use InteractsWithPageTable;
    protected function getTablePage(): string
    {
        return ListCountries::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Countries', $this->getPageTableQuery()->count()),
        ];
    }
}
