<?php

namespace App\Filament\Widgets;

use App\Models\Shoe;
use App\Models\User;
use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Shoe::count())
                ->description('Jumlah sepatu yang tersedia')
                ->color('primary'),

            Stat::make('Total User', User::count())
                ->description('User terdaftar')
                ->color('success'),

            Stat::make('Total Transaksi', ProductTransaction::count())
                ->description('Semua pesanan masuk')
                ->color('info'),

            Stat::make('Pending', ProductTransaction::where('is_paid', false)->count())
                ->description('Belum dibayar')
                ->color('warning'),

            Stat::make('Success', ProductTransaction::where('is_paid', true)->count())
                ->description('Sudah dibayar')
                ->color('success'),
        ];
    }
}
