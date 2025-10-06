@extends('layouts.app') 

@section('title', 'Dashboard') 

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </h2>
                <div class="badge bg-light text-dark p-2">
                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="bi bi-emoji-smile me-2"></i>Selamat Datang!
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1">Login Berhasil! 🎉</h4>
                                    <p class="text-muted mb-0">
                                        Kamu berhasil login ke SneakerStore. Dari sini kamu bisa mengatur profil, 
                                        melihat pesanan, atau kembali belanja.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="bg-light rounded p-3">
                                <i class="bi bi-shop display-4 text-primary mb-2"></i>
                                <p class="small text-muted mb-0">SneakerStore</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-person-gear text-info fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Kelola Profil</h5>
                            <p class="card-text text-muted small">
                                Perbarui informasi profil dan preferensi akun Anda
                            </p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-house-door text-warning fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Lanjut Belanja</h5>
                            <p class="card-text text-muted small">
                                Kembali ke halaman utama untuk melanjutkan belanja
                            </p>
                            <a href="{{ route('front.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats (Optional) -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center py-3">
                            <p class="text-muted mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Butuh bantuan? Hubungi customer service kami
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .card {
        transition: all 0.3s ease;
    }
</style>
@endsection