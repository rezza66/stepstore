<section class="card shadow-sm mb-4">
    <div class="card-body">
        <p class="text-muted mb-4">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        {{-- Verification form --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        {{-- Update Profile form --}}
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">{{ __('Name') }}</label>
                <input id="name" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}"
                    required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
                <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                    required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-3">
                        <p class="mb-1">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="btn btn-link p-0 align-baseline">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success mb-0">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> {{ __('Save') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ __('Saved.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>
