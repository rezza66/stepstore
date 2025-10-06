<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

// 👉 Route homepage pakai FrontController
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details/{shoe:slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

// (opsional) route untuk semua new shoes
Route::get('/new-shoes', [FrontController::class, 'newShoes'])->name('front.new-shoes');

// 👉 Route untuk Order Process
Route::middleware('auth')->group(function () {
    Route::post('/order/begin/{shoe:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');
    Route::get('/order/booking', [OrderController::class, 'booking'])->name('front.booking');
    Route::get('/order/booking/customer-data', [OrderController::class, 'customerData'])->name('front.customer_data');
    Route::post('/order/booking/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('front.save_customer_data');

    Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
    Route::post('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');
    Route::get('/order/finished/{productTransaction:id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');
});

// 👉 Route untuk checkout process
Route::get('/checkout', function () {
    return view('order.order');
})->name('front.checkout');

// 👉 Route dashboard bawaan Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👉 Route profile bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
});


// 👉 Route auth bawaan Breeze
require __DIR__.'/auth.php';
