<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransactions extends BaseWidget
{
     protected int|string|array $columnSpan = 'full';
     protected static ?int $sort = 3;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                ProductTransaction::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')->label('Booking ID'),
                Tables\Columns\TextColumn::make('name')->label('Customer'),
                Tables\Columns\TextColumn::make('shoe.name')->label('Produk'),
                Tables\Columns\IconColumn::make('is_paid')->boolean()->label('Status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i'),
            ]);
    }
}
