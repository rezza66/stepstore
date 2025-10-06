<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Shoe;
use App\Services\OrderService;
use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\ProductTransaction;

class OrderController extends Controller
{
    //
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function saveOrder(StoreOrderRequest $request, Shoe $shoe)
    {
        $validated = $request->validated();

        // Tambahkan shoe_id dari parameter route
        $validated['shoe_id'] = $shoe->id;

        // Simpan ke session
        $this->orderService->beginOrder($validated);

        // Langsung redirect ke booking
        return redirect()->route('front.booking');
    }

    public function booking()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.order', $data);
    }

    public function customerData()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.customer_data', $data);
    }

    public function saveCustomerData(StoreCustomerDataRequest $request)
    {
        // Ambil data validasi (hanya field yang dikirim)
        $validated = $request->validated();

        // Simpan/merge ke session
        $this->orderService->updateCustomerData($validated);

        // Cek data yang sudah ada di session
        $orderData = session('orderData', []);

        // Kalau name & email belum ada → berarti user masih di step pertama
        if (!isset($orderData['address']) || !isset($orderData['phone'])) {
            return redirect()->route('front.customer_data'); // ke form customer_data
        }

        // Kalau semua data customer sudah lengkap → lanjut ke payment
        return redirect()->route('front.payment');
    }


    public function payment()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.payment', $data);
    }

    public function paymentConfirm(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        $productTransactionId = $this->orderService->paymentConfirm($validated);

        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }

        return redirect()->route('front.payment')->withErrors(['error' => 'Payment failed. Please try again.']);
    }

    public function orderFinished(ProductTransaction $productTransaction)
    {
        return view('order.finished', compact('productTransaction'));
    }
}
