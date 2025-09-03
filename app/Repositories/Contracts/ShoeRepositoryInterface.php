<?php

namespace App\Repositories\Contracts;

interface ShoeRepositoryInterface
{
    public function getPopularShoe($limit);

    public function getAllNewShoes();

    public function find($id);
    
    public function getPrice($ticketId);
}