<?php

namespace App\Services;

use App\Models\Shoe;
use App\Models\Category;
use App\Models\Brand;

class FrontService
{
    public function getFrontPageData()
{
    $popularShoes = Shoe::where('is_popular', true)
        ->with(['category', 'brand'])
        ->take(8)
        ->get();
        
    $categories = Category::all();
    $brands = Brand::all();

    $newShoes = Shoe::with(['category', 'brand'])
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

    return [
        'popularShoes' => $popularShoes,
        'categories'   => $categories,
        'brands'       => $brands,
        'newShoes'     => $newShoes, 
    ];
}

}