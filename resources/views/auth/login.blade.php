@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #eef2f6; /* Light Blue-Grey Background */
    }
    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .login-header {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }
    .form-control-lg {
        border-radius: 12px;
        font-size: 0.95rem;
        padding: 12px 15px 12px 45px; /* Space for icon */
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .form-control-lg:focus {
        background-color: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 10;
        font-size: 1.1rem;
    }
    .btn-login {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        transition: transform 0.2s;
    }
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }
</style>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-6 col-lg-5 col-xl-4">

            <div class="card login-card">
                <div class="login-header position-relative">
                    <div class="mb-3 bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mx-auto">
                        <i class="fas fa-user-circle fa-3x text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-1">ស្វាគមន៍ត្រឡប់មកវិញ!</h3>
                    <p class="mb-0 opacity-75 small">សូមបញ្ចូលគណនីរបស់អ្នកដើម្បីបន្ត</p>

                    <div class="position-absolute top-0 start-0 p-4 bg-white opacity-10 rounded-circle" style="margin-left: -20px; margin-top: -20px;"></div>
                    <div class="position-absolute bottom-0 end-0 p-5 bg-white opacity-10 rounded-circle" style="margin-right: -30px; margin-bottom: -30px;"></div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4 position-relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="អ៊ីមែល (Email Address)">
                            @error('email')
                                <span class="invalid-feedback ms-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password"
                                   placeholder="ពាក្យសម្ងាត់ (Password)">
                            @error('password')
                                <span class="invalid-feedback ms-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small user-select-none" for="remember">
                                    ចងចាំខ្ញុំ
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-bold text-primary" href="{{ route('password.request') }}">
                                    ភ្លេចពាក្យសម្ងាត់?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-login text-white">
                                ចូលប្រព័ន្ធ (Login) <i class="fas fa-arrow-right ms-2 small"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small mb-0">មិនទាន់មានគណនីមែនទេ?</p>
                            <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none small">
                                ចុះឈ្មោះគណនីថ្មី (Register Now)
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted opacity-75">
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'My Shop') }}</strong>. Secure Login.
                </small>
            </div>

        </div>
    </div>
</div>
@endsection
