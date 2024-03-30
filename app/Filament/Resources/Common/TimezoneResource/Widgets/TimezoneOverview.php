<?php

namespace App\Filament\Resources\Common\TimezoneResource\Widgets;

use App\Filament\Resources\Common\TimezoneResource\Pages\ListTimezones;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TimezoneOverview extends BaseWidget
{
    use InteractsWithPageTable;
    protected function getTablePage(): string
    {
        return ListTimezones::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Timezones', $this->getPageTableQuery()->count()),
        ];
    }
}
