<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Halaman daftar pesanan user
    public function index()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());

        return view('orders.index', compact('orders'));
    }

    // Halaman detail pesanan user
    public function show($orderId)
    {
        $order = $this->orderService->getUserOrderDetail(Auth::id(), $orderId);

        if (! $order) {
            abort(403, 'Anda tidak berhak melihat pesanan ini.');
        }

        return view('orders.show', compact('order'));
    }
}
