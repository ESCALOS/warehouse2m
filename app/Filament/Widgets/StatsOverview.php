<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Item;
use App\Models\Movement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Empleados Totales', Employee::count()),
            Stat::make('Movimientos diarios', Movement::count()),
            Stat::make('Artículos Totales', Item::count()),
        ];
    }
}
