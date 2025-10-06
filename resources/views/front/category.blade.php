@extends('layouts.app')

@section('title', $category->name)

@section('content')

<div class="container py-5">
<!-- Hero kategori -->
<div class="text-center mb-5">
    <h1 class="fw-bold">{{ $category->name }}</h1>
    <p class="text-muted">Temukan koleksi terbaik di kategori <strong>{{ $category->name }}</strong>.</p>
</div>

@if($shoes->count() > 0)
    <div class="row g-4">
        @foreach($shoes as $shoe)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" 
                             class="card-img-top rounded-top" 
                             alt="{{ $shoe->name }}"
                             style="height: 220px; object-fit: cover;">
                        <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2">
                            {{ $shoe->brand->name }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">{{ $shoe->name }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($shoe->about, 50) }}</p>
                        <p class="fw-bold text-dark mb-3">Rp {{ number_format($shoe->price) }}</p>
                        <a href="{{ route('front.details', $shoe->slug) }}" 
                           class="btn btn-outline-primary w-100 mt-auto">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if(method_exists($shoes, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $shoes->links() }}
        </div>
    @endif
@else
    <div class="alert alert-info text-center">
        Belum ada produk dalam kategori ini.
    </div>
@endif

</div>
@endsection
