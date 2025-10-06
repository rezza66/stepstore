<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\LatestTransactions;
// use Filament\Widgets\Widget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
{
    return [
        StatsOverview::class,       // atas
        SalesChart::class,          // tengah
        LatestTransactions::class,  // bawah
    ];
}

public function getColumns(): int|array
{
    return 1; // satu kolom, semua urut ke bawah
}

}
