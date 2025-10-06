<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use App\Repositories\Contracts\ShoeRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;

class OrderService
{
    protected $categoryRepository;
    protected $promoCodeRepository;
    protected $orderRepository;
    protected $shoeRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        PromoCodeRepositoryInterface $promoCodeRepository,
        OrderRepositoryInterface $orderRepository,
        ShoeRepositoryInterface $shoeRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->promoCodeRepository = $promoCodeRepository;
        $this->orderRepository = $orderRepository;
        $this->shoeRepository = $shoeRepository;
    }

    public function beginOrder(array $data)
    {
        $orderData = [
            'shoe_size' => $data['shoe_size'],
            'shoe_id' => $data['shoe_id'],
        ];

        $this->orderRepository->saveToSession($orderData);
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();

        if (empty($orderData) || !isset($orderData['shoe_id'])) {
            return [
                'orderData' => null,
                'shoe' => null,
            ];
        }

        $shoe = $this->shoeRepository->find($orderData['shoe_id']);

        // Default quantity = 1
        $quantity = $orderData['quantity'] ?? 1;

        $subTotalAmount = $shoe->price * $quantity;

        $taxRate = 0.11;
        $totalTax = $subTotalAmount * $taxRate;

        $grandTotalAmount = $subTotalAmount + $totalTax;

        // Tambahin ke array orderData biar konsisten dipakai di step berikutnya
        $orderData['quantity'] = $quantity;
        $orderData['sub_total_amount'] = $subTotalAmount;
        $orderData['total_tax'] = $totalTax;
        $orderData['grand_total_amount'] = $grandTotalAmount;

        // simpan ulang ke session
        $this->orderRepository->saveToSession($orderData);

        return compact('orderData', 'shoe');
    }


    public function applyPromoCode(string $code, int $subTotalAmount)
    {
        $promo = $this->promoCodeRepository->findByCode($code);

        if ($promo) {
            $discount = $promo->discount_amount;
            $grandTotalAmount = $subTotalAmount - $discount;
            $promoCodeId = $promo->id;

            return [
                'discount' => $discount,
                'grandTotalAmount' => $grandTotalAmount,
                'promoCodeId' => $promoCodeId,
            ];
        }

        return ['error' => 'Kode promo tidak tersedia!'];
    }

    public function saveBookingTransaction(array $data)
    {
        $this->orderRepository->saveToSession($data);
    }

    public function updateCustomerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    public function paymentConfirm(array $validated)
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();
        $productTransactionId = null;

        try {
            DB::transaction(function () use ($validated, &$productTransactionId, $orderData) {

                // Simpan bukti pembayaran (jika ada)
                if (isset($validated['proof']) && $validated['proof'] instanceof \Illuminate\Http\UploadedFile) {
                    $proofPath = $validated['proof']->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                }

                // Lengkapi data transaksi dengan data dari session
                $validated['name']              = $orderData['name'] ?? null;
                $validated['email']             = $orderData['email'] ?? null;
                $validated['phone']             = $orderData['phone'] ?? null;
                $validated['address']           = $orderData['address'] ?? null;
                $validated['post_code']         = $orderData['post_code'] ?? null;
                $validated['city']              = $orderData['city'] ?? null;
                $validated['quantity']          = $orderData['quantity'] ?? 1;
                $validated['sub_total_amount']  = $orderData['sub_total_amount'] ?? 0;
                $validated['grand_total_amount'] = $orderData['grand_total_amount'] ?? 0;
                $validated['discount_amount']   = $orderData['discount_amount'] ?? 0;
                $validated['shoe_id']           = $orderData['shoe_id'] ?? null;
                $validated['shoe_size']         = $orderData['shoe_size'] ?? null;

                $validated['is_paid']           = false;
                $validated['booking_trx_id']    = ProductTransaction::generateUniqueTrxId();

                $validated['user_id']           = Auth::user()->id;


                // Simpan ke DB
                $newTransaction = $this->orderRepository->createTransaction($validated);
                $productTransactionId = $newTransaction->id;
            });

            return $productTransactionId;
        } catch (\Exception $e) {
            Log::error('Error in payment confirmation: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat konfirmasi pembayaran.');
            return null;
        }
    }

    public function getUserOrders(int $userId, int $perPage = 10)
    {
        return $this->orderRepository->getOrdersByUser($userId, $perPage);
    }

    public function getUserOrderDetail(int $userId, int $orderId)
    {
        return $this->orderRepository->getOrderByUserAndId($userId, $orderId);
    }
}
