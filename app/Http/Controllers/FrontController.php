<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shoe;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct()
    {
        $this->frontService = new FrontService();
    }

    // Route: GET /
    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);
    }

    // Route: GET /details/{shoe:slug}
    public function details(Shoe $shoe)
    {
        $shoe->load(['photos', 'sizes', 'category', 'brand']);
        return view('front.details', compact('shoe'));
    }

    // Route: GET /browse/{category:slug}
    public function category(Category $category)
    {
        $shoes = Shoe::where('category_id', $category->id)
            ->with('brand')
            ->paginate(12);

        return view('front.category', compact('category', 'shoes'));
    }

    public function newShoes()
    {
        $newShoes = Shoe::with(['category', 'brand'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('front.new-shoes', compact('newShoes'));
    }
}
