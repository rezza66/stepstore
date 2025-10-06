@extends('layouts.app')

@section('title', $shoe->name)

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Gambar Produk -->
            <div class="col-lg-6">
                <!-- Gambar Utama -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="position-relative">
                            <img id="mainImage" src="{{ asset('storage/' . $shoe->thumbnail) }}"
                                class="img-fluid rounded w-100" style="max-height: 500px; object-fit: cover;"
                                alt="{{ $shoe->name }}">

                            <!-- Badge Kategori -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary px-3 py-2 shadow">
                                    <i class="bi bi-tags-fill"></i> {{ $shoe->category->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail Galeri -->
                @if ($shoe->photos->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        <!-- Thumbnail utama -->
                        <div class="thumbnail-item" style="cursor: pointer;">
                            <img src="{{ asset('storage/' . $shoe->thumbnail) }}"
                                class="img-thumbnail rounded shadow-sm border-2 border-primary" width="90"
                                height="90" style="object-fit: cover;"
                                onclick="changeImage('{{ asset('storage/' . $shoe->thumbnail) }}')"
                                alt="{{ $shoe->name }}">
                        </div>

                        <!-- Thumbnail photos -->
                        @foreach ($shoe->photos as $photo)
                            <div class="thumbnail-item" style="cursor: pointer;">
                                <img src="{{ asset('storage/' . $photo->photo) }}"
                                    class="img-thumbnail rounded shadow-sm hover-border" width="90" height="90"
                                    style="object-fit: cover; transition: all 0.3s;"
                                    onclick="changeImage('{{ asset('storage/' . $photo->photo) }}')"
                                    alt="photo {{ $shoe->name }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Detail Produk -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <!-- Nama Produk -->
                        <h2 class="fw-bold mb-3">{{ $shoe->name }}</h2>

                        <!-- Info Brand & Kategori -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-tags-fill text-primary fs-5 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Category</small>
                                        <span class="fw-semibold">{{ $shoe->category->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-award-fill text-primary fs-5 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Brand</small>
                                        <span class="fw-semibold">{{ $shoe->brand?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="bg-light rounded p-3 mb-4">
                            <small class="text-muted d-block mb-1">Price</small>
                            <h3 class="fw-bold text-success mb-0">
                                Rp{{ number_format($shoe->price, 0, ',', '.') }}
                            </h3>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-info-circle-fill text-primary"></i> Product Description
                            </h6>
                            <p class="text-muted mb-0">{{ $shoe->about }}</p>
                        </div>

                        <hr class="my-4">

                        <!-- Form Pembelian -->
                        <form action="{{ route('front.save_order', ['shoe' => $shoe->slug]) }}" method="POST">
                            @csrf

                            <!-- Pilih Ukuran -->
                            @if ($shoe->sizes->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-3">
                                        <i class="bi bi-rulers"></i> Select Size:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($shoe->sizes as $size)
                                            <input type="radio" class="btn-check" name="shoe_size"
                                                id="size{{ $size->size }}" value="{{ $size->size }}" required>
                                            <label class="btn btn-outline-primary btn-lg" for="size{{ $size->size }}"
                                                style="min-width: 60px;">
                                                {{ $size->size }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-exclamation-circle"></i> Choose the size according to your feet
                                    </small>
                                </div>
                            @endif

                            <!-- Tombol Beli -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg shadow-sm py-3">
                                    <i class="bi bi-bag-check-fill"></i> Buy Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk ganti gambar -->
    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;

            // Update border thumbnail
            document.querySelectorAll('.thumbnail-item img').forEach(img => {
                img.classList.remove('border-primary', 'border-2');
            });
            event.target.classList.add('border-primary', 'border-2');
        }

        // Hover effect untuk thumbnail
        document.querySelectorAll('.thumbnail-item img').forEach(img => {
            img.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            img.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
@endsection
