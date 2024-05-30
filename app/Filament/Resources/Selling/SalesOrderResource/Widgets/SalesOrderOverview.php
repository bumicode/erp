<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Widgets;

use App\Filament\Resources\Selling\SalesOrderResource\Pages\ListSalesOrders;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOrderOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Sales Order', $this->getPageTableQuery()->count()),
            Stat::make('Total Quantity', $this->getPageTableQuery()->sum('total_qty')),
            Stat::make('Average price', number_format($this->getPageTableQuery()->avg('total_amount'), 2)),
        ];
    }

    protected function getTablePage(): string
    {
        return ListSalesOrders::class;
    }
}
