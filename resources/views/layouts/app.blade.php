<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Premium POS') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --prm-grad: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --prm-color: #6366f1;
            --bg-light: #f8fafc;
            --font-kh: 'Kantumruy Pro', sans-serif;
            --font-en: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            font-family: var(--font-kh);
            background-color: var(--bg-light);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.05) 0px, transparent 50%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fw-800 { font-weight: 800; }
        .text-gradient { 
            background: var(--prm-grad); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }

        /* --- Navbar Upgrade --- */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            padding: 0.7rem 0;
            z-index: 1030;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .navbar-brand {
            font-family: var(--font-en);
            font-weight: 800;
            font-size: 1.3rem;
        }

        .nav-link {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b !important;
            padding: 0.6rem 1rem !important;
            border-radius: 14px;
            margin: 0 2px;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--prm-color) !important;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.04);
            transform: translateY(-1px);
        }

        /* --- Profile Capsule --- */
        .profile-capsule {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            padding: 5px 15px 5px 6px !important;
            border-radius: 50px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .avatar-circle {
            width: 32px; height: 32px;
            background: var(--prm-grad);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 800; font-family: var(--font-en);
            margin-right: 10px;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        /* --- Dropdown Premium --- */
        .dropdown-menu {
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-radius: 24px;
            padding: 1.2rem;
            min-width: 300px;
            margin-top: 15px !important;
            animation: animateUp 0.4s ease-out;
        }

        @keyframes animateUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--prm-color);
            transform: translateX(5px);
        }

        .role-badge-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(168, 85, 247, 0.08) 100%);
            border-radius: 18px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        /* --- Layout Styles --- */
        main { flex-grow: 1; }
        .footer { background: white; padding: 3rem 0; border-top: 1px solid #f1f5f9; }

        .btn-logout-custom {
            background: #fff1f2;
            color: #e11d48 !important;
            border-radius: 12px;
        }
        .btn-logout-custom:hover { background: #ffe4e6; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-2">
                    <i class="fas fa-rocket text-primary"></i>
                </div>
                <span class="text-dark fw-800">PREMIUM</span><span class="text-gradient fw-800">POS</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#appNavbar">
                <i class="fas fa-bars-staggered text-primary"></i>
            </button>

            <div class="collapse navbar-collapse" id="appNavbar">
                <ul class="navbar-nav me-auto ps-lg-4">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-store me-1 small"></i> ហាងទំនិញ
                            </a>
                        </li>
                        
                        @if(Auth::user()->role == 'owner')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('owner/dashboard*') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">
                                    <i class="fas fa-chart-pie me-1 small"></i> ស្ថិតិសរុប
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('cashier/dashboard*') ? 'active' : '' }}" href="{{ route('cashier.dashboard') }}">
                                    <i class="fas fa-calculator me-1 small"></i> បញ្ជរលុយ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="fas fa-box-open me-1 small"></i> ស្តុកទំនិញ
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->role == 'cashier')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('cashier/dashboard*') ? 'active' : '' }}" href="{{ route('cashier.dashboard') }}">
                                    <i class="fas fa-calculator me-1 small"></i> បញ្ជរលុយ
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @guest
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">ចូលប្រើ</a></li>
                        <li class="nav-item"><a class="btn btn-primary rounded-pill px-4 fw-800 shadow-sm" href="{{ route('register') }}">ចុះឈ្មោះ</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link profile-capsule dropdown-toggle shadow-none" href="#" data-bs-toggle="dropdown">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="text-dark fw-bold lh-1" style="font-size: 0.85rem;">{{ Auth::user()->name }}</div>
                                    <div class="text-muted text-uppercase fw-800" style="font-size: 0.55rem;">{{ Auth::user()->role }}</div>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                <div class="role-badge-card">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-shield-check text-primary"></i>
                                        <span class="text-dark fw-800 small text-uppercase">គណនី {{ Auth::user()->role }}</span>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.75rem;">គ្រប់គ្រង និងតាមដានអាជីវកម្ម</div>
                                </div>

                                <h6 class="dropdown-header">រហ័ស</h6>
                                @if(Auth::user()->role == 'owner')
                                    <a class="dropdown-item" href="{{ route('owner.dashboard') }}"><i class="fas fa-laptop-code me-2 opacity-50"></i> Admin Panel</a>
                                @endif
                                
                                <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2 opacity-50"></i> ព័ត៌មានផ្ទាល់ខ្លួន</a>
                                
                                <div class="dropdown-divider my-2 opacity-50"></div>
                                
                                <a class="dropdown-item btn-logout-custom fw-bold" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off me-2"></i> ចាកចេញ
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container animate__animated animate__fadeIn">
            @if(session('success'))
                <div class="alert bg-white border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-5">
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 me-3"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="fw-800 text-dark small">ជោគជ័យ</div>
                        <div class="text-muted small">{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-1 text-muted small">&copy; {{ date('Y') }} <span class="fw-800 text-dark">{{ config('app.name') }}</span></p>
            <p class="text-uppercase text-muted fw-800" style="font-size: 0.6rem; letter-spacing: 2px;">Premium Quality POS System</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>