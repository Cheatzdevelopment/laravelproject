@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Kantumruy+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

<div class="container py-5" style="font-family: 'Inter', 'Kantumruy Pro', sans-serif;">

    <div class="row justify-content-center no-print mb-4">
        <div class="col-lg-9 d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border">
            <a href="{{ url()->previous() }}" class="btn-action-back text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i> ត្រឡប់ក្រោយ
            </a>
            <div class="d-flex gap-3">
                <button onclick="window.print()" class="btn-action-print">
                    <i class="fas fa-print me-2"></i> បោះពុម្ពវិក្កយបត្រ
                </button>
                <button class="btn-action-download">
                    <i class="fas fa-file-pdf me-2"></i> PDF
                </button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="invoice-container shadow-2xl animate__animated animate__fadeIn">
                
                <div class="invoice-top-accent"></div>

                <div class="p-5">
                    <div class="row mb-5">
                        <div class="col-7">
                            <div class="d-flex align-items-center mb-4">
                                <div class="brand-logo">
                                    <i class="fas fa-bolt text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="fw-800 text-dark mb-0">{{ config('app.name', 'PREMIUM SHOP') }}</h3>
                                    <span class="text-primary fw-bold small text-uppercase" style="letter-spacing: 2px;">Modern Retail Solution</span>
                                </div>
                            </div>
                            <div class="store-info">
                                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> មហាវិថីព្រះនរោត្តម, ភ្នំពេញ, កម្ពុជា</p>
                                <p class="mb-1"><i class="fas fa-phone-alt me-2"></i> +855 (0) 12 345 678</p>
                                <p class="mb-0"><i class="fas fa-globe me-2"></i> www.premiumshop.com.kh</p>
                            </div>
                        </div>
                        <div class="col-5 text-end">
                            <h1 class="invoice-title">INVOICE</h1>
                            <div class="invoice-meta mt-3">
                                <div class="meta-item">
                                    <span class="label">Invoice No:</span>
                                    <span class="value">#INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="label">Date:</span>
                                    <span class="value">{{ $order->created_at->format('d M, Y') }}</span>
                                </div>
                                <div class="meta-item mt-2">
                                    <span class="status-pill {{ $order->status == 'paid' ? 'paid' : 'pending' }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5 p-4 rounded-4 bg-light-soft border border-dashed">
                        <div class="col-sm-6 border-end border-2">
                            <label class="section-label">ផ្ញើជូន (Bill To):</label>
                            <h5 class="fw-bold text-dark mb-1">{{ $order->user->name }}</h5>
                            <p class="text-muted small mb-0">{{ $order->user->email }}</p>
                            <p class="text-muted small">{{ $order->note ?? 'ការដឹកជញ្ជូនធម្មតា' }}</p>
                        </div>
                        <div class="col-sm-6 ps-sm-5">
                            <label class="section-label">វិធីសាស្ត្របង់ប្រាក់:</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="payment-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ strtoupper($order->payment_method ?? 'CASH ON DELIVERY') }}</span>
                            </div>
                            <small class="text-muted">រាល់ការទូទាត់រួចរាល់ មិនអាចដកប្រាក់វិញបានទេ។</small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th class="ps-0">បរិយាយទំនិញ (Description)</th>
                                    <th class="text-center">ចំនួន (Qty)</th>
                                    <th class="text-end">តម្លៃរាយ (Price)</th>
                                    <th class="text-end pe-0">សរុប (Amount)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-0 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="item-thumb d-print-none">
                                                <img src="{{ $item->product->image_url }}" alt="">
                                            </div>
                                            <div class="ms-3">
                                                <p class="fw-bold text-dark mb-0">{{ $item->product->name }}</p>
                                                <small class="text-muted">SKU: {{ str_pad($item->product_id, 6, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-600">x{{ $item->quantity }}</td>
                                    <td class="text-end text-muted">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end pe-0 fw-bold text-dark">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-md-6 order-2 order-md-1">
                            <div class="d-flex align-items-center gap-4 mt-3">
                                <div class="qr-code-box">
                                    <i class="fas fa-qrcode fa-4x text-dark opacity-75"></i>
                                </div>
                                <div>
                                    <p class="fw-bold text-dark mb-1 small">Scan for E-Receipt</p>
                                    <p class="text-muted x-small mb-0">វិក្កយបត្រនេះត្រូវបានបង្កើតដោយប្រព័ន្ធកុំព្យូទ័រ និងមានសុពលភាពតាមច្បាប់។</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 order-1 order-md-2">
                            <div class="total-summary p-4 rounded-4 bg-dark text-white shadow-lg">
                                <div class="d-flex justify-content-between mb-2 opacity-75">
                                    <span>សរុប (Subtotal)</span>
                                    <span>${{ number_format($order->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 opacity-75">
                                    <span>អាករលើតម្លៃបន្ថែម (VAT 0%)</span>
                                    <span>$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mt-3 pt-3 border-top border-secondary">
                                    <span class="h6 fw-bold">សរុបរួម (Total Due)</span>
                                    <span class="h3 fw-800 text-warning mb-0">${{ number_format($order->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 pt-5 text-center d-none d-print-flex">
                        <div class="col-4">
                            <div class="signature-line"></div>
                            <p class="small fw-bold text-muted">អតិថិជន / Customer</p>
                        </div>
                        <div class="col-4 offset-4">
                            <div class="signature-line"></div>
                            <p class="small fw-bold text-muted">បេឡាករ / Authorized Signature</p>
                        </div>
                    </div>

                </div>

                <div class="invoice-footer text-center p-5 pt-0">
                    <p class="text-primary fw-bold mb-1">Thank you for your business!</p>
                    <p class="text-muted x-small">ប្រសិនបើមានចម្ងល់អំពីវិក្កយបត្រនេះ សូមទាក់ទងមកកាន់លេខ 012 345 678។</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4f46e5;
        --dark-color: #1e293b;
        --accent-color: #f59e0b;
        --light-soft: #f8fafc;
    }

    .fw-800 { font-weight: 800; }
    .fw-600 { font-weight: 600; }
    .x-small { font-size: 0.7rem; }

    /* Invoice Container */
    .invoice-container {
        background: #fff;
        border-radius: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .invoice-top-accent {
        height: 12px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    /* Brand Styling */
    .brand-logo {
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .invoice-title {
        font-size: 3.5rem;
        font-weight: 900;
        color: #f1f5f9;
        margin-bottom: 0;
        line-height: 1;
        letter-spacing: -2px;
    }

    /* Meta Info */
    .section-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: block;
    }

    .meta-item { display: flex; justify-content: flex-end; gap: 15px; }
    .meta-item .label { color: #64748b; font-size: 0.85rem; }
    .meta-item .value { color: var(--dark-color); font-weight: 700; font-size: 0.85rem; }

    /* Pills */
    .status-pill {
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .status-pill.paid { background: #dcfce7; color: #166534; }
    .status-pill.pending { background: #fef3c7; color: #92400e; }

    /* Table Styling */
    .invoice-table thead th {
        background: var(--light-soft);
        border: none;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 15px 10px;
    }

    .item-thumb {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* QR & Signature */
    .qr-code-box {
        padding: 10px;
        border: 2px solid #f1f5f9;
        border-radius: 15px;
        background: white;
    }

    .signature-line {
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 10px;
        width: 150px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Buttons Style */
    .btn-action-back { color: #64748b; font-weight: 700; font-size: 0.9rem; transition: 0.3s; }
    .btn-action-back:hover { color: var(--primary-color); }
    
    .btn-action-print {
        background: var(--dark-color);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-action-print:hover { background: #000; transform: translateY(-2px); }

    .btn-action-download {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        transition: 0.3s;
    }

    /* Print Overrides */
    @media print {
        body { background: white !important; }
        .invoice-container { border: none !important; box-shadow: none !important; border-radius: 0 !important; }
        .no-print { display: none !important; }
        .bg-dark { background-color: #1e293b !important; -webkit-print-color-adjust: exact; }
        .text-warning { color: #f59e0b !important; }
        .invoice-top-accent { -webkit-print-color-adjust: exact; }
    }
</style>

@endsection