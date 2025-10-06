@extends('layouts.app')

@section('title', 'Home - Sneaker Store')

@section('content') <!-- Hero -->
    <div class="p-5 mb-5 bg-dark text-light rounded-3 shadow-sm">
        <div class="container py-5 text-center">
            <h1 class="display-4 fw-bold">Welcome to Sneaker Store</h1>
            <p class="lead mb-4">Find your favorite shoes from the best brands at attractive prices.</p> <a href="#"
                class="btn btn-lg btn-warning px-4 fw-semibold">Shop Now</a>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-5">
        <h2 class="mb-4 fw-bold text-center">Browse by Categories</h2>
        <div class="row justify-content-center">
            @foreach ($categories as $cat)
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="{{ route('front.category', $cat->slug) }}" class="text-decoration-none text-dark">
                        <div class="border rounded shadow-sm p-3 h-100 hover-shadow transition text-center bg-white">
                            <img src="{{ asset('storage/' . $cat->icon) }}" alt="{{ $cat->name }}" class="img-fluid mb-2"
                                style="max-height:50px;">
                            <p class="mt-2 mb-0 fw-semibold">{{ $cat->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Shoes -->
    <div class="mb-5">
        <h2 class="mb-4 fw-bold text-center">🔥 Popular Shoes</h2>
        <div class="row">
            @foreach ($popularShoes as $shoe)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" class="card-img-top rounded-top"
                            alt="{{ $shoe->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $shoe->name }}</h5>
                            <p class="card-text small text-muted flex-grow-1">
                                {{ $shoe->brand->name }} • {{ $shoe->category->name }}
                            </p>
                            <p class="fw-bold text-dark">Rp{{ number_format($shoe->price, 0, ',', '.') }}</p>
                            <a href="{{ route('front.details', $shoe->slug) }}"
                                class="btn btn-outline-primary btn-sm mt-auto">
                                View Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- New Shoes -->
    <div class="mb-5">
        <h2 class="mb-4 fw-bold text-center">🆕 New Arrivals</h2>
        <div class="row">
            @foreach ($newShoes as $shoe)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                        <img src="{{ asset('storage/' . $shoe->thumbnail) }}" class="card-img-top rounded-top"
                            alt="{{ $shoe->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $shoe->name }}</h5>
                            <p class="card-text small text-muted flex-grow-1">
                                {{ $shoe->brand->name }} • {{ $shoe->category->name }}
                            </p>
                            <p class="fw-bold text-dark">Rp{{ number_format($shoe->price, 0, ',', '.') }}</p>
                            <a href="{{ route('front.details', $shoe->slug) }}"
                                class="btn btn-outline-success btn-sm mt-auto">
                                View Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('front.new-shoes') }}" class="btn btn-lg btn-dark px-4">
                View All New Shoes
            </a>
        </div>
    </div>

@endsection
