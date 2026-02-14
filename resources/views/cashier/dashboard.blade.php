@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="fw-extra-bold text-dark mb-1">ផ្ទាំងគ្រប់គ្រងអ្នកគិតលុយ</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item text-muted"><i class="fas fa-home me-1"></i> Dashboard</li>
                    <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Cashier Terminal</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex align-items-center bg-white p-2 rounded-4 shadow-sm border">
                <div class="me-3 ps-2">
                    <span class="d-block small text-muted fw-bold text-uppercase" style="font-size: 10px;">ស្ថានីយ៍សកម្ម</span>
                    <span class="fw-bold text-dark">Terminal #01 - Active</span>
                </div>
                <div class="bg-success rounded-3 p-2 text-white shadow-sm">
                    <i class="fas fa-signal"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        @php
            $stats = [
                ['label' => 'ទំនិញសរុប', 'val' => \App\Models\Product::count(), 'icon' => 'fa-box-open', 'color' => 'primary', 'desc' => 'In Inventory'],
                ['label' => 'ការកម្មង់រង់ចាំ', 'val' => \App\Models\Order::where('status', 'pending')->count(), 'icon' => 'fa-spinner fa-spin', 'color' => 'warning', 'desc' => 'Waiting Action'],
                ['label' => 'ចំណូលថ្ងៃនេះ', 'val' => '$' . number_format(\App\Models\Order::whereDate('created_at', now())->sum('total_price'), 2), 'icon' => 'fa-wallet', 'color' => 'success', 'desc' => 'Net Revenue'],
                ['label' => 'អតិថិជនថ្ងៃនេះ', 'val' => \App\Models\Order::whereDate('created_at', now())->distinct('user_id')->count(), 'icon' => 'fa-users', 'color' => 'info', 'desc' => 'Unique Visitors']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-5 stat-card overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} p-3 rounded-4 me-3">
                            <i class="fas {{ $stat['icon'] }} fa-xl"></i>
                        </div>
                        <div>
                            <p class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px;">{{ $stat['label'] }}</p>
                            <h3 class="fw-extra-bold mb-0 text-dark">{{ $stat['val'] }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted fw-600 opacity-75">
                        {{ $stat['desc'] }}
                    </div>
                </div>
                <div class="stat-progress bg-{{ $stat['color'] }}"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-9">
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
                <div class="card-header bg-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="fw-extra-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i> ប្រតិបត្តិការចុងក្រោយ</h5>
                        </div>
                        <div class="col-md-6 text-md-end mt-2 mt-md-0">
                            <div class="premium-search-box d-inline-flex align-items-center bg-light px-3 py-2 rounded-pill">
                                <i class="fas fa-search text-muted me-2"></i>
                                <input type="text" class="border-0 bg-transparent shadow-none small fw-bold" placeholder="ស្វែងរកលេខកូដវិក័យបត្រ..." style="outline:none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr class="text-muted small text-uppercase">
                                    <th class="ps-4 py-3">Transaction</th>
                                    <th>Customer & Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Timestamp</th>
                                    <th class="text-end pe-4">Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Order::with('user')->latest()->take(10)->get() as $order)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-extra-bold text-dark">#ORD-{{ $order->id }}</div>
                                        <span class="text-muted" style="font-size: 11px;">Receipt generated</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width:32px; height:32px; font-size:12px;">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark small">{{ $order->user->name }}</div>
                                                @if($order->order_type == 'delivery')
                                                    <span class="text-info fw-bold" style="font-size: 10px;"><i class="fas fa-motorcycle me-1"></i> DELIVERY</span>
                                                @else
                                                    <span class="text-secondary fw-bold" style="font-size: 10px;"><i class="fas fa-store me-1"></i> PICKUP</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-extra-bold text-primary">${{ number_format($order->total_price, 2) }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'paid' => ['bg' => 'success', 'text' => 'Success'],
                                                'pending' => ['bg' => 'warning', 'text' => 'Pending'],
                                                'cancelled' => ['bg' => 'danger', 'text' => 'Failed']
                                            ];
                                            $c = $statusColors[$order->status] ?? ['bg' => 'secondary', 'text' => $order->status];
                                        @endphp
                                        <div class="badge-dot bg-{{ $c['bg'] }}-subtle text-{{ $c['bg'] }} px-3 py-2 rounded-pill fw-bold" style="font-size: 11px;">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> {{ ucfirst($c['text']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark small fw-600">{{ $order->created_at->diffForHumans() }}</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $order->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle p-0 shadow-sm" style="width:30px; height:30px;" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 small fw-bold py-2" href="{{ route('invoice', $order->id) }}"><i class="fas fa-print me-2 text-primary"></i> បោះពុម្ពវិក័យបត្រ</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item rounded-3 small fw-bold py-2 text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> លុបការកម្មង់</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-5">No Data Found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card border-0 shadow-sm rounded-5 mb-4 bg-primary text-white overflow-hidden position-relative">
                <div class="card-body p-4 z-1 position-relative">
                    <h5 class="fw-extra-bold mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-white text-primary border-0 fw-bold py-3 rounded-4 shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i> បន្ថែមទំនិញថ្មី
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-primary-light fw-bold py-3 rounded-4">
                            <i class="fas fa-boxes me-2"></i> គ្រប់គ្រងស្តុក
                        </a>
                    </div>
                </div>
                <div class="position-absolute bottom-0 end-0 opacity-10" style="transform: translate(20%, 20%)">
                    <i class="fas fa-rocket fa-8x"></i>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 p-4 bg-white h-100">
                <h6 class="fw-extra-bold text-dark mb-4">Stock Analytics</h6>
                
                @php
                    $lowStock = \App\Models\Product::where('stock', '<', 5)->take(3)->get();
                @endphp

                <div class="mb-4">
                    <label class="small text-muted fw-bold d-block mb-3">LOW STOCK ALERTS</label>
                    @foreach($lowStock as $p)
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-danger-subtle text-danger rounded-3 me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small mb-0">{{ $p->name }}</div>
                            <div class="text-danger fw-bold" style="font-size: 11px;">Only {{ $p->stock }} left</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <hr class="opacity-10">
                <a href="#" class="btn btn-light w-100 fw-bold small rounded-4 py-2 mt-auto">View Full Report <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS FOR PREMIUM FEEL */
    .fw-extra-bold { font-weight: 800; }
    .fw-600 { font-weight: 600; }
    
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .stat-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 100%;
        opacity: 0.2;
    }

    .bg-primary { background-color: #4f46e5 !important; }
    .text-primary { color: #4f46e5 !important; }
    .bg-primary-subtle { background-color: rgba(79, 70, 229, 0.1) !important; }
    
    .bg-success-subtle { background-color: rgba(16, 185, 129, 0.1) !important; }
    .text-success { color: #10b981 !important; }
    
    .bg-warning-subtle { background-color: rgba(245, 158, 11, 0.1) !important; }
    .text-warning { color: #f59e0b !important; }
    
    .bg-danger-subtle { background-color: rgba(239, 68, 68, 0.1) !important; }
    .text-danger { color: #ef4444 !important; }

    .bg-light-subtle { background-color: #f1f5f9; }
    
    .btn-white { background-color: white; }
    .btn-primary-light { background-color: rgba(255, 255, 255, 0.15); border: none; color: white; }
    .btn-primary-light:hover { background-color: rgba(255, 255, 255, 0.25); color: white; }

    .rounded-5 { border-radius: 1.5rem !important; }
    .rounded-4 { border-radius: 1rem !important; }

    .premium-search-box input::placeholder { color: #94a3b8; }
    
    .table thead th { border-bottom: none; }
    .table td { border-top: 1px solid #f1f5f9; padding: 1rem 0.5rem; }

    .dropdown-item:active { background-color: #4f46e5; }
    
    /* Image tag trigger for system overview */
    
</style>
@endsection