<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ProductTransaction;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Penjualan';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Ambil total transaksi per bulan (jumlah transaksi)
        $data = ProductTransaction::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_map(
                fn($m) => date('F', mktime(0, 0, 0, $m, 1)), 
                array_keys($data)
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // bisa diganti 'bar' kalau mau chart batang
    }
}
