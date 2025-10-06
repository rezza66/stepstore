<section class="card shadow-sm mb-4">
    <div class="card-body">
        <p class="text-muted mb-4">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- Current Password --}}
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label fw-semibold">
                    {{ __('Current Password') }}
                </label>
                <input id="update_password_current_password" name="current_password" type="password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label for="update_password_password" class="form-label fw-semibold">
                    {{ __('New Password') }}
                </label>
                <input id="update_password_password" name="password" type="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label fw-semibold">
                    {{ __('Confirm Password') }}
                </label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> {{ __('Save') }}
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ __('Saved.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>
