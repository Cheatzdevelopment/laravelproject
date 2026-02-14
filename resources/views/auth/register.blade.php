@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #eef2f6; /* Light Blue-Grey Background */
    }
    .register-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .register-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); /* Green Gradient */
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
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
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
    .btn-register {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        transition: transform 0.2s;
    }
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }
</style>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-7 col-lg-6 col-xl-5">

            <div class="card register-card">
                <div class="register-header position-relative">
                    <div class="mb-3 bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mx-auto">
                        <i class="fas fa-user-plus fa-3x text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-1">បង្កើតគណនីថ្មី</h3>
                    <p class="mb-0 opacity-75 small">សូមបំពេញព័ត៌មានខាងក្រោមដើម្បីចុះឈ្មោះ</p>

                    <div class="position-absolute top-0 start-0 p-4 bg-white opacity-10 rounded-circle" style="margin-left: -20px; margin-top: -20px;"></div>
                    <div class="position-absolute bottom-0 end-0 p-5 bg-white opacity-10 rounded-circle" style="margin-right: -30px; margin-bottom: -30px;"></div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="ឈ្មោះពេញ (Full Name)">
                            @error('name')
                                <span class="invalid-feedback ms-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 position-relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="អ៊ីមែល (Email Address)">
                            @error('email')
                                <span class="invalid-feedback ms-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password"
                                   placeholder="ពាក្យសម្ងាត់ (Password)">
                            @error('password')
                                <span class="invalid-feedback ms-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 position-relative">
                            <i class="fas fa-lock-open input-icon"></i>
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="បញ្ជាក់ពាក្យសម្ងាត់ (Confirm Password)">
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-register text-white">
                                ចុះឈ្មោះ (Register) <i class="fas fa-arrow-right ms-2 small"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small mb-0">មានគណនីរួចហើយមែនទេ?</p>
                            <a href="{{ route('login') }}" class="fw-bold text-success text-decoration-none small">
                                ចូលប្រើប្រាស់នៅទីនេះ (Login Here)
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted opacity-75">
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'My Shop') }}</strong>. Secure Registration.
                </small>
            </div>

        </div>
    </div>
</div>
@endsection
