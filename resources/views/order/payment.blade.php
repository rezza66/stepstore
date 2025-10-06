@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <h2 class="fw-bold text-primary mb-2">
            <i class="bi bi-credit-card-2-front-fill"></i> Payment
        </h2>
        <p class="text-muted">Complete your payment to process the order</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar: Summary & Customer Data -->
        <div class="col-lg-5">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bag-check-fill"></i> Order Summary
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Product Info -->
                    <div class="d-flex align-items-start mb-4 pb-4 border-bottom">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" 
                             alt="{{ $shoe->name }}" 
                             class="img-fluid rounded shadow-sm me-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2">{{ $shoe->name }}</h6>
                            <div class="mb-1">
                                <span class="text-muted small">Quantity:</span>
                                <span class="badge bg-primary ms-1">{{ $orderData['quantity'] }}x</span>
                            </div>
                            <div class="text-muted small">
                                Unit Price: <span class="fw-semibold text-dark">Rp{{ number_format($shoe->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price Details -->
                    <div class="mb-0">
                        <div class="row mb-2">
                            <div class="col-7">
                                <span class="text-muted">Subtotal:</span>
                            </div>
                            <div class="col-5 text-end">
                                <span class="fw-semibold">Rp{{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-7">
                                <span class="text-muted">Tax (11%):</span>
                            </div>
                            <div class="col-5 text-end">
                                <span class="fw-semibold">Rp{{ number_format($orderData['total_tax'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="row border-top pt-3">
                            <div class="col-7">
                                <h5 class="mb-0 fw-bold">Total Payment:</h5>
                            </div>
                            <div class="col-5 text-end">
                                <h4 class="mb-0 fw-bold text-success">Rp{{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Data -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-circle"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-person-fill text-primary me-2 mt-1"></i>
                            <div>
                                <small class="text-muted d-block">Full Name</small>
                                <span class="fw-semibold">{{ $orderData['name'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-envelope-fill text-primary me-2 mt-1"></i>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-semibold">{{ $orderData['email'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-telephone-fill text-primary me-2 mt-1"></i>
                            <div>
                                <small class="text-muted d-block">Phone Number</small>
                                <span class="fw-semibold">{{ $orderData['phone'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-primary me-2 mt-1"></i>
                            <div>
                                <small class="text-muted d-block">Full Address</small>
                                <span class="fw-semibold">{{ $orderData['address'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-building text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">City</small>
                                    <span class="fw-semibold">{{ $orderData['city'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 mb-0">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-mailbox text-primary me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Postal Code</small>
                                    <span class="fw-semibold">{{ $orderData['post_code'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-lg-7">
            <!-- Bank Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bank"></i> Bank Account Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-info-circle-fill fs-5 me-3"></i>
                        <div>
                            <strong>Attention!</strong> Please transfer to one of the accounts below with the exact amount stated.
                        </div>
                    </div>

                    <!-- Example Bank Accounts -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border border-primary h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-bank2 text-primary fs-1"></i>
                                    </div>
                                    <h6 class="fw-bold text-primary mb-2">Bank BCA</h6>
                                    <p class="mb-1 fw-bold fs-5">1234567890</p>
                                    <small class="text-muted">a.n. Shoe Store</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border border-success h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-bank2 text-success fs-1"></i>
                                    </div>
                                    <h6 class="fw-bold text-success mb-2">Bank Mandiri</h6>
                                    <p class="mb-1 fw-bold fs-5">0987654321</p>
                                    <small class="text-muted">a.n. Shoe Store</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Display error from session --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Display validation error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Upload Proof Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-upload"></i> Upload Transfer Proof
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('front.payment_confirm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-file-earmark-image"></i> Payment Proof
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   name="proof" 
                                   class="form-control form-control-lg" 
                                   accept="image/*"
                                   required>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-exclamation-circle"></i> Format: JPG, PNG, or JPEG. Max 2MB
                            </small>
                        </div>

                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <small>Make sure your transfer proof is clear and shows the correct amount.</small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm py-3">
                                <i class="bi bi-check-circle-fill"></i> Confirm Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Process Timeline -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-clock-history"></i> Next Steps
                    </h6>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <small class="fw-bold">1</small>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold">Upload Transfer Proof</p>
                            <small class="text-muted">Upload your payment proof</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <small class="fw-bold">2</small>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold">Admin Verification</p>
                            <small class="text-muted">Payment will be verified within 24 hours</small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <small class="fw-bold">3</small>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold">Order Processing</p>
                            <small class="text-muted">Your order will be shipped after verification</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection