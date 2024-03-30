<?php

namespace App\Filament\Resources\Common\CurrencyResource\Widgets;

use App\Filament\Resources\Common\CurrencyResource\Pages\ListCurrencies;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CurrencyOverview extends BaseWidget
{
    use InteractsWithPageTable;
    protected function getTablePage(): string
    {
        return ListCurrencies::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Currencies', $this->getPageTableQuery()->count()),
        ];
    }
}
