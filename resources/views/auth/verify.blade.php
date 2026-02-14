@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h3 class="fw-bold mb-0">📧 បញ្ជាក់អាសយដ្ឋានអ៊ីមែល (Verify Email)</h3>
                    <small>សូមពិនិត្យមើលអ៊ីមែលរបស់អ្នកដើម្បីបន្ត</small>
                </div>

                <div class="card-body p-5 text-center">
                    <div class="mb-4 text-warning">
                        <i class="bi bi-envelope-exclamation" style="font-size: 4rem;"></i>
                    </div>

                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            តំណភ្ជាប់ថ្មីត្រូវបានផ្ញើទៅកាន់អ៊ីមែលរបស់អ្នករួចរាល់ហើយ។
                            <br>
                            <small>(A fresh verification link has been sent to your email address.)</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="fw-bold mb-3">សូមពិនិត្យមើលប្រអប់សារអ៊ីមែលរបស់អ្នក</h5>

                    <p class="text-muted mb-4">
                        មុននឹងបន្ត សូមស្វែងរកតំណភ្ជាប់បញ្ជាក់នៅក្នុងអ៊ីមែលដែលយើងបានផ្ញើទៅ។
                        <br>
                        (Before proceeding, please check your email for a verification link.)
                    </p>

                    <hr>

                    <p class="mb-3">
                        ប្រសិនបើអ្នកមិនទទួលបានអ៊ីមែលទេ (If you did not receive the email):
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            <i class="bi bi-send"></i> ផ្ញើLink មកខ្ញុំម្តងទៀត (Resend Link)
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a class="text-muted text-decoration-none" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-verify').submit();">
                   <i class="bi bi-box-arrow-left"></i> ចាកចេញ (Logout)
                </a>
                <form id="logout-form-verify" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
