@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row align-items-center mb-5">
        <div class="col-md-7">
            <h2 class="fw-extra-bold text-dark mb-1">ផ្ទាំងគ្រប់គ្រងទូទៅ <span class="text-primary">Dashboard</span></h2>
            <p class="text-muted mb-0">សួស្តី, នេះជាទិដ្ឋភាពទូទៅនៃអាជីវកម្មរបស់អ្នកសម្រាប់ថ្ងៃនេះ។</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex bg-white p-2 rounded-5 shadow-sm border">
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fas fa-file-invoice-dollar me-2"></i> របាយការណ៍លម្អិត
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card-kpi bg-primary shadow-primary">
                <div class="kpi-icon-wrapper">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="mt-4">
                    <span class="text-white-50 small fw-bold text-uppercase">ការលក់សរុប (Revenue)</span>
                    <h2 class="fw-extra-bold text-white mb-0 mt-1">${{ number_format(\App\Models\Order::sum('total_price'), 2) }}</h2>
                    <div class="kpi-trend mt-2">
                        <span class="badge bg-white bg-opacity-20 rounded-pill"><i class="fas fa-arrow-up me-1"></i> 12%</span>
                        <span class="ms-2 text-white-50 x-small">Vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-kpi bg-white shadow-sm border-0">
                <div class="kpi-icon-wrapper bg-info-subtle text-info">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="mt-4">
                    <span class="text-muted small fw-bold text-uppercase">ការកម្មង់ (Orders)</span>
                    <h2 class="fw-extra-bold text-dark mb-0 mt-1">{{ \App\Models\Order::count() }}</h2>
                    <div class="mt-2 text-info small fw-bold">
                        <i class="fas fa-check-circle me-1"></i> Completed Orders
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-kpi bg-white shadow-sm border-0">
                <div class="kpi-icon-wrapper bg-warning-subtle text-warning">
                    <i class="fas fa-box"></i>
                </div>
                <div class="mt-4">
                    <span class="text-muted small fw-bold text-uppercase">មុខទំនិញ (Products)</span>
                    <h2 class="fw-extra-bold text-dark mb-0 mt-1">{{ \App\Models\Product::count() }}</h2>
                    <div class="mt-2">
                        <a href="{{ route('products.index') }}" class="text-decoration-none text-warning small fw-bold">Manage Stock <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-kpi bg-white shadow-sm border-0">
                <div class="kpi-icon-wrapper bg-dark text-white">
                    <i class="fas fa-users"></i>
                </div>
                <div class="mt-4">
                    <span class="text-muted small fw-bold text-uppercase">បុគ្គលិក (Staff)</span>
                    <h2 class="fw-extra-bold text-dark mb-0 mt-1">{{ \App\Models\User::where('role', '!=', 'user')->count() }}</h2>
                    <div class="mt-2">
                        <a href="{{ route('owner.users') }}" class="text-decoration-none text-muted small fw-bold">Manage Roles <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-extra-bold text-dark mb-0">ស្ថិតិនៃការលក់</h5>
                        <p class="text-muted small mb-0">ប្រៀបធៀបចំណូលប្រចាំសប្តាហ៍</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light rounded-pill px-3 py-1 small fw-bold border" data-bs-toggle="dropdown">
                            This Week <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 350px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-5 h-100 overflow-hidden">
                <div class="card-header bg-white p-4 border-0 pb-0">
                    <h5 class="fw-extra-bold text-dark mb-0">ប្រតិបត្តិការថ្មីៗ</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush mt-2">
                        @forelse(\App\Models\Order::with('user')->latest()->take(6)->get() as $order)
                        <div class="list-group-item px-4 py-3 border-0 border-bottom-light d-flex align-items-center">
                            <div class="flex-shrink-0 bg-light rounded-4 p-3 text-primary me-3">
                                <i class="fas fa-receipt fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0 fw-bold">#ORD-{{ $order->id }}</h6>
                                    <span class="fw-extra-bold text-primary">${{ number_format($order->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                    <span class="status-dot {{ $order->status == 'paid' ? 'bg-success' : 'bg-warning' }}"></span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                            <p class="text-muted">No recent orders found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-4">
                    <a href="#" class="btn btn-light rounded-pill px-4 small fw-bold">មើលទាំងអស់</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #4f46e5;
        --info: #0ea5e9;
        --warning: #f59e0b;
    }

    .fw-extra-bold { font-weight: 800; }
    .x-small { font-size: 10px; }

    /* KPI Cards Styling */
    .card-kpi {
        padding: 30px;
        border-radius: 30px;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .card-kpi:hover { transform: translateY(-10px); }

    .kpi-icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 1.5rem;
    }

    .bg-primary { background: linear-gradient(135deg, #4f46e5, #6366f1) !important; }
    .shadow-primary { box-shadow: 0 20px 40px rgba(79, 70, 229, 0.2); }
    .bg-primary .kpi-icon-wrapper { background: rgba(255,255,255,0.2); color: white; }
    
    .bg-info-subtle { background: #e0f2fe; }
    .bg-warning-subtle { background: #fef3c7; }

    /* Recent Transactions Styling */
    .border-bottom-light { border-bottom: 1px solid #f1f5f9; }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; }

    .rounded-5 { border-radius: 2rem !important; }

    /* Chart Tooltip Customization */
    #salesChart { filter: drop-shadow(0px 10px 15px rgba(79, 70, 229, 0.1)); }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Create Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: [1200, 1900, 1500, 2800, 2400, 3500, 3100],
                    backgroundColor: gradient,
                    borderColor: '#4f46e5',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Plus Jakarta Sans', size: 14, weight: '800' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 14 },
                        padding: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) { return '$' + context.parsed.y.toLocaleString(); }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', weight: 'bold' },
                            callback: function(v) { return '$' + v; }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection