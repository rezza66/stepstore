@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">📦 Order Details</h2>
            <p class="text-muted mb-0">View the complete information of your order</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="row g-4">
        <!-- Left: Order Details -->
        <div class="col-lg-8">
            <!-- Product Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">🛒 Ordered Product</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset('storage/' . ($order->shoe->thumbnail ?? 'default.jpg')) }}" 
                             alt="{{ $order->shoe->name ?? 'Product' }}" 
                             class="rounded border me-4 shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold mb-2">{{ $order->shoe->name ?? '-' }}</h5>
                            <p class="text-muted mb-2">Quantity: <span class="fw-semibold">{{ $order->quantity }}</span> item(s)</p>
                            <p class="mb-0">Unit Price: 
                                <span class="fw-bold text-primary">Rp {{ number_format($order->shoe->price ?? 0, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">📑 Order Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Booking ID</small>
                            <span class="badge bg-dark rounded-pill fs-6 px-3 py-2">{{ $order->booking_trx_id }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Order Date</small>
                            <span class="fw-semibold">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">💳 Payment Status</h5>
                </div>
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        @if($order->is_paid)
                            <span class="badge bg-success rounded-pill px-4 py-2 fs-6">
                                <i class="bi bi-check-circle me-2"></i>Paid
                            </span>
                        @else
                            <span class="badge bg-warning text-dark rounded-pill px-4 py-2 fs-6">
                                <i class="bi bi-clock me-2"></i>Unpaid
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">💰 Payment Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Rp {{ number_format($order->grand_total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Taxes & Fees</span>
                        <span class="fw-semibold">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-4 fw-bold text-primary">Rp {{ number_format($order->grand_total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 p-3">
                    <small class="text-muted d-flex align-items-center">
                        <i class="bi bi-shield-check me-2"></i>
                        Your payment is safe and encrypted
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}
.badge {
    font-weight: 500;
}
.btn:hover {
    opacity: 0.9;
}
@media (max-width: 991.98px) {
    .sticky-top {
        position: relative !important;
        top: 0 !important;
    }
}
</style>
@endsection
