@extends('layouts.app')

@section('title', 'Data Customer')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <h2 class="fw-bold text-primary mb-2">
            <i class="bi bi-person-fill-check"></i> Data Customer
        </h2>
        <p class="text-muted">Lengkapi informasi pengiriman Anda</p>
    </div>

    <div class="row g-4">
        <!-- Ringkasan Pesanan (Sidebar) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-lg-top" style="top: 20px;">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bag-check-fill"></i> Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Info Produk -->
                    <div class="d-flex align-items-start mb-4 pb-4 border-bottom">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" 
                             alt="{{ $shoe->name }}"
                             class="img-fluid rounded shadow-sm me-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2">{{ $shoe->name }}</h6>
                            <div class="mb-1">
                                <span class="text-muted small">Jumlah:</span>
                                <span class="badge bg-primary ms-1">{{ $orderData['quantity'] }}x</span>
                            </div>
                            <div class="text-muted small">
                                Harga Satuan: <span class="fw-semibold text-dark">Rp{{ number_format($shoe->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Harga -->
                    <div class="mb-3">
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
                                <span class="text-muted">Pajak (11%):</span>
                            </div>
                            <div class="col-5 text-end">
                                <span class="fw-semibold">Rp{{ number_format($orderData['total_tax'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="row border-top pt-3">
                            <div class="col-7">
                                <h5 class="mb-0 fw-bold">Total:</h5>
                            </div>
                            <div class="col-5 text-end">
                                <h5 class="mb-0 fw-bold text-success">Rp{{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Data Customer -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-geo-alt-fill"></i> Informasi Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('front.save_customer_data') }}" method="POST">
                        @csrf
                        
                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-house-door-fill"></i> Alamat Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="address" 
                                      class="form-control form-control-lg" 
                                      rows="3"
                                      placeholder="Jl. Contoh No. 123, RT/RW 01/02"
                                      required>{{ $orderData['address'] ?? '' }}</textarea>
                            <small class="text-muted">Masukkan alamat lengkap dengan nomor rumah, RT/RW</small>
                        </div>

                        <!-- No. HP -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-telephone-fill"></i> No. Handphone
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control" 
                                       placeholder="08123456789"
                                       value="{{ $orderData['phone'] ?? '' }}" 
                                       required>
                            </div>
                            <small class="text-muted">Nomor yang dapat dihubungi oleh kurir</small>
                        </div>

                        <div class="row">
                            <!-- Kota -->
                            <div class="col-md-7 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="bi bi-building"></i> Kota/Kabupaten
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="city" 
                                       class="form-control form-control-lg" 
                                       placeholder="Contoh: Jakarta"
                                       value="{{ $orderData['city'] ?? '' }}" 
                                       required>
                            </div>

                            <!-- Kode Pos -->
                            <div class="col-md-5 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="bi bi-mailbox"></i> Kode Pos
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="post_code" 
                                       class="form-control form-control-lg" 
                                       placeholder="12345"
                                       maxlength="5"
                                       value="{{ $orderData['post_code'] ?? '' }}"
                                       required>
                            </div>
                        </div>

                        <!-- Alert Info -->
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                <small>Pastikan semua data yang Anda masukkan sudah benar sebelum melanjutkan ke pembayaran.</small>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm py-3">
                                <i class="bi bi-credit-card-fill"></i> Lanjut ke Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection