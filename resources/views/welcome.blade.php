@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Kantumruy Pro', sans-serif;
        background-color: #f8f9fa;
    }

    /* Modern Hero Gradient */
    .hero-section {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        position: relative;
        overflow: hidden;
    }
    .hero-pattern {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(circle at 20% 150%, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 50%);
        pointer-events: none;
    }
</style>

<div class="container py-4">

    <div class="hero-section rounded-5 p-5 mb-5 text-white shadow-lg text-center">
        <div class="hero-pattern"></div>
        <div class="position-relative z-1 py-4">
            <h1 class="display-4 fw-bold mb-3">🥤 ស្វាគមន៍មកកាន់ {{ config('app.name', 'My Shop') }} 🍱</h1>
            <p class="fs-5 fw-light opacity-75 mb-4 col-lg-8 mx-auto">
                ប្រព័ន្ធលក់ទំនិញទំនើប រហ័ស និងងាយស្រួល។<br>
                កម្មង់អាហារ និងភេសជ្ជៈដែលអ្នកចូលចិត្តនៅទីនេះ ជាមួយរសជាតិដើម និងអនាម័យខ្ពស់!
            </p>

            <div class="d-flex justify-content-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm px-5 transition-btn">
                        <i class="fas fa-sign-in-alt me-2"></i> ចូលគណនី
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg rounded-pill fw-bold px-5 transition-btn">
                        <i class="fas fa-user-plus me-2"></i> ចុះឈ្មោះ
                    </a>
                @else
                    @if(Auth::user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm px-4">
                            <i class="fas fa-tachometer-alt me-2"></i> Owner Dashboard
                        </a>
                    @elseif(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm px-4">
                            <i class="fas fa-user-shield me-2"></i> Admin Dashboard
                        </a>
                    @elseif(Auth::user()->isCashier())
                        <a href="{{ route('cashier.dashboard') }}" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm px-4">
                            <i class="fas fa-cash-register me-2"></i> POS System
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-warning text-dark btn-lg rounded-pill fw-bold shadow-sm px-5 transition-btn">
                            <i class="fas fa-shopping-cart me-2"></i> ចាប់ផ្តើមកម្មង់
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-4 feature-card text-center">
                <div class="card-body">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">ដឹកជញ្ជូនរហ័ស</h5>
                    <p class="text-muted small">សេវាកម្មដឹកជញ្ជូនដល់កន្លែង មិនឱ្យរង់ចាំយូរ ធានាគុណភាព។</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-4 feature-card text-center">
                <div class="card-body">
                    <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mb-3">
                        <i class="fas fa-utensils fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">រសជាតិឆ្ងាញ់</h5>
                    <p class="text-muted small">ចម្អិនដោយចុងភៅជំនាញ ប្រើប្រាស់វត្ថុធាតុដើមថ្មីៗ និងអនាម័យ។</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-4 feature-card text-center">
                <div class="card-body">
                    <div class="icon-box bg-info bg-opacity-10 text-info mx-auto mb-3">
                        <i class="fas fa-qrcode fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">ទូទាត់ងាយស្រួល</h5>
                    <p class="text-muted small">ទូទាត់ប្រាក់បានយ៉ាងងាយស្រួលតាមរយៈ KHQR គ្រប់ធនាគារ។</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h3 class="fw-bold text-dark m-0">
            <span class="text-primary me-2">✦</span>មុខម្ហូបពេញនិយម
        </h3>
        <a href="{{ route('home') }}" class="btn btn-white border shadow-sm rounded-pill fw-bold small px-3">
            មើលទាំងអស់ <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden">
                <div class="position-relative bg-light" style="height: 180px;">
                    <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&q=80&w=400"
                         class="w-100 h-100 object-fit-cover transition-zoom" alt="Coffee">
                    <span class="position-absolute top-0 end-0 m-2 badge bg-white text-dark shadow-sm rounded-pill">
                        <i class="fas fa-star text-warning"></i> 5.0
                    </span>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">កាហ្វេទឹកដោះគោ</h6>
                    <p class="text-muted small mb-3">Iced Latte រសជាតិដើម</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold text-primary mb-0">$2.50</span>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-circle shadow-sm btn-icon">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden">
                <div class="position-relative bg-light" style="height: 180px;">
                    <img src="https://images.unsplash.com/photo-1603133872878-684f208fb74b?auto=format&fit=crop&q=80&w=400"
                         class="w-100 h-100 object-fit-cover transition-zoom" alt="Fried Rice">
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">បាយឆាសាច់ជ្រូក</h6>
                    <p class="text-muted small mb-3">Fried Rice ពិសេស</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold text-primary mb-0">$3.00</span>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-circle shadow-sm btn-icon">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden">
                <div class="position-relative bg-light" style="height: 180px;">
                    <img src="https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?auto=format&fit=crop&q=80&w=400"
                         class="w-100 h-100 object-fit-cover transition-zoom" alt="Green Tea">
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">តែបៃតង</h6>
                    <p class="text-muted small mb-3">Matcha Green Tea</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold text-primary mb-0">$2.00</span>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-circle shadow-sm btn-icon">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden grayscale">
                <div class="position-relative bg-light" style="height: 180px;">
                    <img src="https://images.unsplash.com/photo-1548839140-29a749e1cf4d?auto=format&fit=crop&q=80&w=400"
                         class="w-100 h-100 object-fit-cover" alt="Water">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                        <span class="badge bg-danger px-3 py-2 rounded-pill shadow">អស់ស្តុក</span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">ទឹកសុទ្ធ</h6>
                    <p class="text-muted small mb-3">Mineral Water</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold text-muted mb-0">$0.50</span>
                        <button class="btn btn-secondary rounded-circle shadow-sm btn-icon" disabled>
                            <i class="fas fa-ban"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling */
    .icon-box {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feature-card {
        transition: transform 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }

    /* Product Card */
    .product-card {
        transition: all 0.3s ease;
        background: white;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }

    /* Zoom Effect */
    .transition-zoom {
        transition: transform 0.6s ease;
    }
    .product-card:hover .transition-zoom {
        transform: scale(1.1);
    }

    .object-fit-cover { object-fit: cover; }

    /* Button Hover */
    .transition-btn:hover {
        transform: translateY(-2px);
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Grayscale for out of stock */
    .grayscale img {
        filter: grayscale(100%);
    }
</style>
@endsection
