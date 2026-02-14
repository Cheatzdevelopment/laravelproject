@extends('layouts.app')

@section('content')
<style>
    /* Admin Theme Colors */
    :root {
        --admin-primary: #6366f1; /* Indigo */
        --admin-bg: #eef2ff;
    }

    body {
        background-color: #f3f4f6;
        font-family: 'Kantumruy Pro', sans-serif;
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15) !important;
    }

    .icon-box {
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 16px;
        font-size: 1.5rem;
    }

    /* Table Styling */
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .avatar-product {
        width: 40px; height: 40px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-user-shield text-primary me-2"></i> ផ្ទាំងគ្រប់គ្រង (Admin Dashboard)
            </h2>
            <p class="text-muted mb-0">
                មើលទិន្នន័យទូទៅ និងគ្រប់គ្រងប្រតិបត្តិការហាង
            </p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('shop.index') }}" class="btn btn-white shadow-sm border fw-bold text-dark transition-btn">
                <i class="fas fa-store me-2 text-primary"></i> ទៅកាន់ហាង
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm fw-bold transition-btn">
                <i class="fas fa-plus-circle me-2"></i> បន្ថែមទំនិញថ្មី
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">ទំនិញសរុប (Total Products)</p>
                        <h2 class="fw-bold text-dark mb-0 display-6">{{ \App\Models\Product::count() }}</h2>
                        <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Available</span>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card position-relative">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">ជិតអស់ស្តុក (Low Stock)</p>
                        @php $lowStock = \App\Models\Product::where('stock', '<', 5)->count(); @endphp
                        <h2 class="fw-bold {{ $lowStock > 0 ? 'text-danger' : 'text-success' }} mb-0 display-6">{{ $lowStock }}</h2>
                        <span class="text-danger small fw-bold"><i class="fas fa-exclamation-triangle me-1"></i> Needs Restock</span>
                    </div>
                    <div class="icon-box bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-sort-amount-down"></i>
                    </div>
                </div>
                @if($lowStock > 0)
                    <div class="position-absolute top-0 start-0 w-100 h-100 border border-2 border-danger rounded-4 opacity-25 animate-pulse"></div>
                @endif
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">ការកម្មង់ថ្ងៃនេះ (Today)</p>
                        <h2 class="fw-bold text-dark mb-0 display-6">
                            {{ \App\Models\Order::whereDate('created_at', today())->count() }}
                        </h2>
                        <span class="text-info small fw-bold">New Orders</span>
                    </div>
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">ចំណូលសរុប (Total Revenue)</p>
                        <h2 class="fw-bold text-success mb-0 display-6">
                            ${{ number_format(\App\Models\Order::sum('total_price'), 2) }}
                        </h2>
                        <span class="text-success small fw-bold">Lifetime Sales</span>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center px-4">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-clock text-primary me-2"></i> ការកម្មង់ថ្មីៗ (Recent Orders)
                    </h5>
                    <a href="#" class="btn btn-sm btn-light border fw-bold text-muted">View All</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small fw-bold text-muted">
                            <tr>
                                <th class="ps-4 py-3">Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Order::with('user')->latest()->take(6)->get() as $order)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 32px; height: 32px;">
                                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                        </div>
                                        <span>{{ $order->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="fw-bold text-dark">${{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    @if($order->status == 'completed' || $order->status == 'paid')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Completed</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('invoice', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" target="_blank">
                                        Invoice
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">មិនទាន់មានការកម្មង់ទេ</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0 px-4">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> ត្រូវបញ្ចូលស្តុក (Restock)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse(\App\Models\Product::where('stock', '<', 5)->take(5)->get() as $product)
                        <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3 border-light">
                            <div class="d-flex align-items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="avatar-product me-3">
                                @else
                                    <div class="avatar-product bg-light d-flex align-items-center justify-content-center me-3 text-muted">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $product->name }}</h6>
                                    <small class="text-danger fw-bold">សល់តែ: {{ $product->stock }}</small>
                                </div>
                            </div>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-light text-primary rounded-circle">
                                <i class="fas fa-edit"></i>
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted">
                            <i class="fas fa-check-circle text-success mb-2 fs-4"></i>
                            <p class="mb-0 small">ស្តុកមានគ្រប់គ្រាន់ទាំងអស់!</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="position-absolute top-0 end-0 p-5 bg-white opacity-10 rounded-circle" style="margin-top: -30px; margin-right: -30px;"></div>
                    <h5 class="fw-bold mb-2">គ្រប់គ្រងប្រព័ន្ធ</h5>
                    <p class="opacity-75 small mb-3">អ្នកអាចកែប្រែព័ត៌មានទំនិញ ឬបន្ថែមថ្មីបានគ្រប់ពេល។</p>
                    <div class="d-grid">
                        <a href="{{ route('products.index') }}" class="btn btn-white text-primary fw-bold shadow-sm">
                            <i class="fas fa-boxes me-2"></i> ទៅកាន់ឃ្លាំងទំនិញ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .text-success { color: #059669 !important; }

    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .text-warning { color: #d97706 !important; }

    /* Pulse Animation for Low Stock */
    @keyframes pulse-border {
        0% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.02); opacity: 0.2; }
        100% { transform: scale(1); opacity: 0.5; }
    }
    .animate-pulse {
        animation: pulse-border 2s infinite;
    }
</style>
@endsection
