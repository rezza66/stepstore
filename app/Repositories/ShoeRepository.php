<?php

namespace App\Repositories;

use App\Models\Shoe;
use App\Repositories\Contracts\ShoeRepositoryInterface;

class ShoeRepository implements ShoeRepositoryInterface
{
    // Ambil sepatu populer
    public function getPopularShoes($limit = 4)
    {
        return Shoe::where('is_popular', true)
            ->take($limit)
            ->get();
    }

    // Ambil semua sepatu terbaru
    public function getAllNewShoes()
    {
        return Shoe::latest()->get();
    }

    // Cari sepatu berdasarkan ID
    public function find($id)
    {
        return Shoe::find($id);
    }

    // Ambil harga sepatu
    public function getPrice($shoeId)
    {
        $shoe = $this->find($shoeId);
        return $shoe ? $shoe->price : 0;
    }
}
