@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center">
        <i class="bi bi-person-circle me-2"></i> Profile Settings
    </h2>

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Update Profile Info --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-person-lines-fill me-2"></i> Update Profile Information
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-warning text-dark fw-semibold">
                <i class="bi bi-key-fill me-2"></i> Update Password
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-danger text-white fw-semibold">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete Account
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>

</div>
@endsection
