<?php

namespace App\Repositories;

use App\Models\ProductTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    // Simpan transaksi baru ke DB
    public function createTransaction(array $data)
    {
        return ProductTransaction::create($data);
    }

    // Cari transaksi berdasarkan booking_trx_id + phone
    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber)
    {
        return ProductTransaction::where('booking_trx_id', $bookingTrxId)
            ->where('phone', $phoneNumber) // konsisten dengan request
            ->first();
    }

    // Simpan data order ke session (merge dengan data lama)
    public function saveToSession(array $data)
    {
        $orderData = session('orderData', []);
        $orderData = array_merge($orderData, $data);
        session(['orderData' => $orderData]);
    }

    // Ambil data order dari session
    public function getOrderDataFromSession()
    {
        return session('orderData', []);
    }

    // Update data order di session (sama dengan saveToSession)
    public function updateSessionData(array $data)
    {
        $this->saveToSession($data);
    }

    // Ambil semua pesanan milik user tertentu
    public function getOrdersByUser($userId, $perPage = 10)
    {
        return ProductTransaction::where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    // Ambil detail pesanan milik user tertentu
    public function getOrderByUserAndId($userId, $orderId)
    {
        return ProductTransaction::where('user_id', $userId)
            ->where('id', $orderId)
            ->first();
    }
}
