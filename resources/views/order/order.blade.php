@extends('layouts.app')

@section('title', 'Booking Order')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <h2 class="fw-bold text-primary mb-2">
            <i class="bi bi-bookmark-check-fill"></i> Order Review
        </h2>
        <p class="text-muted">Please review your order details before proceeding</p>
    </div>

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" 
                             class="img-fluid rounded-3 shadow-sm" 
                             style="max-height: 280px; object-fit: cover;" 
                             alt="{{ $shoe->name }}">
                    </div>
                    <h5 class="fw-bold mb-3">{{ $shoe->name }}</h5>
                    <div class="d-flex justify-content-between align-items-center mb-2 px-3">
                        <span class="text-muted">Size:</span>
                        <span class="badge bg-primary rounded-pill">{{ $orderData['shoe_size'] ?? '-' }}</span>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <h4 class="text-success fw-bold mb-0">
                            Rp{{ number_format($shoe->price, 0, ',', '.') }}
                        </h4>
                        <small class="text-muted">per item</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Form & Customer Data -->
        <div class="col-lg-8">
            <form action="{{ route('front.save_customer_data') }}" method="POST">
                @csrf
                
                <!-- Price Summary -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calculator"></i> Purchase Summary
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Quantity Input -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="bi bi-cart-plus"></i> Quantity:
                            </label>
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control form-control-lg" 
                                   min="1" 
                                   value="{{ $orderData['quantity'] ?? 1 }}" 
                                   required>
                        </div>

                        <!-- Price Review -->
                        <div class="border-top pt-3">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <span class="text-muted">Subtotal:</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-semibold">Rp<span id="subTotal">{{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}</span></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <span class="text-muted">Tax (11%):</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-semibold">Rp<span id="tax">{{ number_format($orderData['total_tax'], 0, ',', '.') }}</span></span>
                                </div>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-6">
                                    <h5 class="mb-0 fw-bold">Total:</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <h5 class="mb-0 fw-bold text-success">Rp<span id="grandTotal">{{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Data Form -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle"></i> Customer Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-fill"></i> Full Name:
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control form-control-lg" 
                                   placeholder="Enter your full name"
                                   value="{{ $orderData['name'] ?? '' }}" 
                                   required>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-envelope-fill"></i> Email:
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-lg" 
                                   placeholder="example@email.com"
                                   value="{{ $orderData['email'] ?? '' }}" 
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm py-3">
                        <i class="bi bi-arrow-right-circle-fill"></i> Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Live price update -->
<script>
    const quantityInput = document.querySelector('input[name="quantity"]');
    const subTotalEl = document.getElementById('subTotal');
    const taxEl = document.getElementById('tax');
    const grandTotalEl = document.getElementById('grandTotal');
    const price = {{ $shoe->price }};

    quantityInput.addEventListener('input', function() {
        const qty = parseInt(this.value) || 1;
        const subTotal = price * qty;
        const tax = subTotal * 0.11;
        const grandTotal = subTotal + tax;

        subTotalEl.textContent = subTotal.toLocaleString('id-ID');
        taxEl.textContent = tax.toLocaleString('id-ID');
        grandTotalEl.textContent = grandTotal.toLocaleString('id-ID');
    });
</script>
@endsection
