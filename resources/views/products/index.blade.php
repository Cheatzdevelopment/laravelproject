@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row align-items-end mb-4 animate__animated animate__fadeIn">
        <div class="col-md-7">
            <h2 class="fw-extra-bold text-dark mb-1">📦 ការគ្រប់គ្រងបញ្ជីសារពើភ័ណ្ឌ</h2>
            <p class="text-muted mb-0">ប្រព័ន្ធតាមដានស្តុក និងសុខភាពទំនិញឆ្លាតវៃ (2026 Edition)</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm rounded-4 overflow-hidden">
                <button onclick="window.print()" class="btn btn-white border fw-bold text-dark py-2 px-3">
                    <i class="fas fa-print me-2"></i> Print
                </button>
                <a href="{{ route('products.create') }}" class="btn btn-primary fw-bold py-2 px-4 animate__animated animate__pulse animate__infinite">
                    <i class="fas fa-plus-circle me-2"></i> បន្ថែមទំនិញថ្មី
                </a>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 mb-5 animate__animated animate__fadeInUp">
        <button class="cat-tab active" onclick="filterCategory('all', this)">ទាំងអស់</button>
        <button class="cat-tab" onclick="filterCategory('អាហារពេលព្រឹក', this)">អាហារពេលព្រឹក</button>
        <button class="cat-tab" onclick="filterCategory('អាហារថ្ងៃត្រង់', this)">អាហារថ្ងៃត្រង់</button>
        <button class="cat-tab" onclick="filterCategory('ភេសជ្ជៈ', this)">ភេសជ្ជៈ</button>
    </div>

    <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 bg-white p-3 stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded-4 me-3">
                        <i class="fas fa-layer-group fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Skus</span>
                        <h4 class="fw-extra-bold mb-0 text-dark">{{ $products->count() }} មុខ</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 bg-white p-3 stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-danger-subtle text-danger p-3 rounded-4 me-3">
                        <i class="fas fa-exclamation-circle fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Stock Alerts</span>
                        <h4 class="fw-extra-bold mb-0 text-danger">{{ $products->where('stock', '<=', 5)->count() }} ជិតអស់ស្តុក</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 bg-white p-3 stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success-subtle text-success p-3 rounded-4 me-3">
                        <i class="fas fa-wallet fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Valuation</span>
                        @php $totalValue = $products->sum(fn($p) => $p->price * $p->stock); @endphp
                        <h4 class="fw-extra-bold mb-0 text-dark">${{ number_format($totalValue, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-header bg-white p-4 border-0">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <h5 class="fw-extra-bold mb-0">បញ្ជីមុខទំនិញលម្អិត</h5>
                </div>
                <div class="col-md-8 text-md-end">
                    <div class="d-flex flex-wrap justify-content-md-end gap-2">
                        <div class="premium-search-box d-flex align-items-center bg-light px-3 py-2 rounded-pill border">
                            <i class="fas fa-search text-muted me-2"></i>
                            <input type="text" id="inventorySearch" class="border-0 bg-transparent shadow-none small fw-bold" placeholder="ស្វែងរកឈ្មោះ..." style="outline:none; width: 250px;">
                        </div>
                        <select id="statusFilter" class="form-select rounded-pill border px-3 small fw-bold bg-light" style="width: 150px; cursor: pointer;">
                            <option value="all">ស្ថានភាពទាំងអស់</option>
                            <option value="ok">ស្តុកច្រើន</option>
                            <option value="low">ស្តុកតិច</option>
                            <option value="out">អស់ស្តុក</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                        <tr class="text-muted small text-uppercase fw-800">
                            <th class="ps-4 py-3">Thumbnail</th>
                            <th>Product Info</th>
                            <th>Category</th>
                            <th>Pricing</th>
                            <th>Inventory Bar</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody">
                        @forelse($products as $product)
                        <tr class="inventory-row animate__animated animate__fadeIn" 
                            data-status="{{ $product->stock <= 0 ? 'out' : ($product->stock <= 5 ? 'low' : 'ok') }}"
                            data-category="{{ $product->category }}">
                            <td class="ps-4">
                                <div class="product-thumb-premium" onclick="showImage('{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300?text=No+Image' }}', '{{ $product->name }}')" data-bs-toggle="modal" data-bs-target="#imageModal">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="no-img-icon bg-light text-muted small"><i class="fas fa-image"></i></div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="fw-extra-bold text-dark mb-0 product-name-cell">{{ $product->name }}</div>
                                <div class="text-muted x-small"><i class="fas fa-barcode me-1"></i> ID: PRO-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>

                            <td>
                                @php
                                    $catColor = [
                                        'អាហារពេលព្រឹក' => 'bg-info-subtle text-info',
                                        'អាហារថ្ងៃត្រង់' => 'bg-warning-subtle text-warning',
                                        'ភេសជ្ជៈ' => 'bg-primary-subtle text-primary'
                                    ];
                                    $colorClass = $catColor[$product->category] ?? 'bg-light text-muted';
                                @endphp
                                <span class="badge {{ $colorClass }} rounded-pill px-3 py-2 fw-bold" style="font-size: 10px;">
                                    {{ $product->category ?? 'មិនកំណត់' }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-extra-bold text-primary">${{ number_format($product->price, 2) }}</div>
                                <div class="text-muted x-small">Retail Price</div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2" style="min-width: 120px;">
                                    @php 
                                        $percent = min(($product->stock / 50) * 100, 100); 
                                        $barColor = $product->stock <= 0 ? 'bg-secondary' : ($product->stock <= 5 ? 'bg-danger' : ($product->stock <= 15 ? 'bg-warning' : 'bg-success'));
                                    @endphp
                                    <div class="flex-grow-1">
                                        <div class="progress rounded-pill shadow-none" style="height: 8px; background-color: #f1f5f9;">
                                            <div class="progress-bar {{ $barColor }} rounded-pill" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-dark small">{{ $product->stock }}</span>
                                </div>
                            </td>

                            <td>
                                @if($product->stock <= 0)
                                    <span class="status-badge status-out">Out of Stock</span>
                                @elseif($product->stock <= 5)
                                    <span class="status-badge status-low">Low Stock</span>
                                @else
                                    <span class="status-badge status-ok">Healthy</span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="action-btn-edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn-delete" onclick="return confirm('លុបទំនិញនេះ?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted fw-bold">មិនមានទិន្នន័យ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Category Tabs Styling */
    .cat-tab {
        padding: 12px 30px;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .cat-tab:hover { background: #f8fafc; transform: translateY(-2px); }
    .cat-tab.active {
        background: white;
        color: #4f46e5;
        border-color: #4f46e5;
        box-shadow: 0 10px 15px rgba(79, 70, 229, 0.1);
    }

    /* Existing Styles */
    :root { --primary: #4f46e5; --danger: #ef4444; --warning: #f59e0b; --success: #10b981; }
    .fw-extra-bold { font-weight: 800; }
    .x-small { font-size: 11px; }
    .bg-info-subtle { background-color: #e0f2fe !important; color: #0369a1 !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; color: #92400e !important; }
    .bg-primary-subtle { background-color: #eef2ff !important; color: #4f46e5 !important; }
    
    .status-badge { font-size: 10px; font-weight: 800; padding: 6px 14px; border-radius: 50px; text-transform: uppercase; }
    .status-out { background: #fef2f2; color: #991b1b; }
    .status-low { background: #fffbeb; color: #92400e; }
    .status-ok { background: #f0fdf4; color: #166534; }

    .product-thumb-premium { width: 55px; height: 55px; border-radius: 15px; overflow: hidden; border: 2px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); cursor: pointer; transition: 0.3s; }
    .product-thumb-premium img { width: 100%; height: 100%; object-fit: cover; }
    
    .action-btn-edit, .action-btn-delete { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 12px; border: none; transition: 0.3s; }
    .action-btn-edit { background: #f0f7ff; color: #3b82f6; text-decoration: none; }
    .action-btn-delete { background: #fff5f5; color: #f87171; }
</style>

<script>
    let currentCategory = 'all';

    function filterCategory(cat, btn) {
        currentCategory = cat;
        // Update UI Tabs
        document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
    }

    function applyFilters() {
        const searchVal = document.getElementById('inventorySearch').value.toLowerCase();
        const statusVal = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('.inventory-row');

        rows.forEach(row => {
            const name = row.querySelector('.product-name-cell').textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            const category = row.getAttribute('data-category');

            const matchSearch = name.includes(searchVal);
            const matchStatus = (statusVal === 'all' || status === statusVal);
            const matchCategory = (currentCategory === 'all' || category === currentCategory);

            row.style.display = (matchSearch && matchStatus && matchCategory) ? '' : 'none';
        });
    }

    document.getElementById('inventorySearch').addEventListener('input', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
</script>
@endsection