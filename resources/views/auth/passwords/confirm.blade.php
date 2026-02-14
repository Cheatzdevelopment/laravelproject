@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h3 class="fw-bold mb-0">🔐 ការពារសុវត្ថិភាព (Security Check)</h3>
                    <small>សូមបញ្ជាក់ពាក្យសម្ងាត់របស់អ្នក</small>
                </div>

                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock text-dark" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">
                            សូមមេត្តាបញ្ជាក់ពាក្យសម្ងាត់របស់អ្នក មុននឹងបន្តទៅកាន់ទំព័រនេះ។
                            <br>
                            (Please confirm your password before continuing.)
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-secondary">ពាក្យសម្ងាត់ (Password)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password" placeholder="********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold shadow-sm">
                                បញ្ជាក់ពាក្យសម្ងាត់ (Confirm Password)
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="btn btn-link text-decoration-none text-secondary" href="{{ route('password.request') }}">
                                    ភ្លេចពាក្យសម្ងាត់មែនទេ? (Forgot Your Password?)
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ url()->previous() }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left"></i> ត្រឡប់ក្រោយ (Go Back)
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
