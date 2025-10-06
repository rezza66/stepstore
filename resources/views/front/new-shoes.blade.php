@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">New Shoes</h2>
    <div class="row">
        @forelse ($newShoes as $shoe)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $shoe->thumbnail) }}" class="card-img-top" alt="{{ $shoe->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shoe->name }}</h5>
                        <p class="card-text">
                            {{ $shoe->brand->name }} - {{ $shoe->category->name }} <br>
                            <strong>${{ number_format($shoe->price, 2) }}</strong>
                        </p>
                        <a href="{{ route('front.details', $shoe->slug) }}" class="btn btn-sm btn-outline-primary">
                            View Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>No new shoes available.</p>
        @endforelse
    </div>
</div>
@endsection
