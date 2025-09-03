<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use App\Models\ProductTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Session;

class OrderRepository implements OrderRepositoryInterface
{
    // Membuat transaksi baru
    public function createTransaction(array $data)
    {
        return ProductTransaction::create($data);
    }

    // Mencari transaksi berdasarkan booking_trx_id dan nomor HP
    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber)
    {
        return ProductTransaction::where('booking_trx_id', $bookingTrxId)
            ->where('phone_number', $phoneNumber)
            ->first();
    }

    // Simpan data order ke session
    public function saveToSession(array $data)
    {
        Session::put('orderData', $data);
    }

    // Ambil data order dari session
    public function getOrderDataFromSession()
    {
        return session('orderData', []);
    }

    // Update data order di session
    public function updateSessionData(array $data)
    {
        $orderData = session('orderData', []);
        $orderData = array_merge($orderData, $data);
        session(['orderData' => $orderData]);
    }
}
