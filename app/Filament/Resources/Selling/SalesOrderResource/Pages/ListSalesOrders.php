<?php

namespace App\Filament\Resources\Selling\SalesOrderResource\Pages;

use App\Filament\Resources\Selling\SalesOrderResource;
use App\Models\Selling\SalesOrder;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListSalesOrders extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SalesOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'draft' => Tab::make()->query(fn ($query) => $query->where('status', 'draft')),
            'processing' => Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'shipped' => Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            SalesOrderResource\Widgets\SalesOrderOverview::class,
        ];
    }
}
