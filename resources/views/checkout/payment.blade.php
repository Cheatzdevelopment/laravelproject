@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="payment-premium-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="modern-khqr-card animate__animated animate__zoomIn">
                    <div class="card-branding-top">
                        <div class="bakong-logo-wrap">
    
                            <span class="khqr-pill">KHQR</span>
                        </div>
                        <div class="live-status">
                            <span class="pulse-icon"></span>
                            <span class="status-text">Encrypted</span>
                        </div>
                    </div>

                    <div class="main-payment-body">
                        <div class="merchant-profile-box">
                            <div class="merchant-avatar-wrapper">
                                <div class="avatar-inner">
                                    {{ strtoupper(substr(config('app.name', 'P'), 0, 1)) }}
                                </div>
                                <div class="verified-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <h5 class="merchant-name">{{ config('app.name', 'Premium POS') }}</h5>
                            
                            <div class="price-container">
                                <div class="price-tag-large">
                                    <span class="currency-symbol">$</span>
                                    <span class="amount-val">{{ number_format($totalAmount, 2) }}</span>
                                </div>
                                <div class="free-shipping-tag animate__animated animate__bounceIn animate__delay-1s">
                                    <i class="fas fa-shipping-fast"></i> Free Delivery
                                </div>
                            </div>
                            
                            <div class="payment-summary-box">
                                <div class="summary-item">
                                    <span>Subtotal</span>
                                    <span class="val">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="summary-divider"></div>
                                <div class="summary-item">
                                    <span>Shipping</span>
                                    <span class="val text-success fw-bold">Free</span>
                                </div>
                            </div>
                        </div>

                        <div class="qr-scanner-visual">
                            <div class="qr-box-container">
                                <div class="scanner-line"></div>
                                <div class="qr-corner top-left"></div>
                                <div class="qr-corner top-right"></div>
                                <div class="qr-corner bottom-left"></div>
                                <div class="qr-corner bottom-right"></div>
                                
                                <div class="qr-image-wrap">
                                    <img src="https://i.pinimg.com/originals/84/24/10/84241003986c2bd490018fe8f6899792.jpg" alt="QR Code">
                                    <div class="qr-overlay-logo">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="timer-display-modern" id="timer-badge">
                                <i class="far fa-clock"></i>
                                Expires in: <span id="timer" class="fw-bold">01:00</span>
                            </div>
                        </div>

                        <div class="supported-banks-area">
                            <p class="small-title">Pay with any mobile banking app</p>
                            <div class="bank-logos-shimmer">
                                <div class="bank-logos-row">
                                    <span class="bank-chip">ABA</span>
                                    <span class="bank-chip">Wing</span>
                                    <span class="bank-chip">Acleda</span>
                                    <span class="bank-chip">Canadia</span>
                                </div>
                            </div>
                        </div>

                        <div class="payment-actions px-4 pb-4">
                            <form id="payment-form" action="{{ route('payment.confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="KHQR">
                                <input type="hidden" name="amount" value="{{ $totalAmount }}">
                                
                                <button type="submit" class="btn-confirm-pay" id="btn-pay">
                                    <span class="btn-text">Confirm Payment</span>
                                    <div class="btn-icon">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </button>
                            </form>
                            <a href="{{ url()->previous() }}" class="link-cancel-payment">
                                Cancel Transaction
                            </a>
                        </div>
                    </div>
                </div>

                <div class="footer-trust-labels">
                    <div class="trust-item"><i class="fas fa-lock"></i> 256-bit SSL</div>
                    <div class="trust-item"><i class="fas fa-bolt"></i> Instant Settlement</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --khqr-primary: #e11d48;
        --khqr-dark: #0f172a;
        --glass-bg: #ffffff;
        --success-soft: #dcfce7;
        --success-deep: #166534;
        --border-color: #f1f5f9;
    }

    .payment-premium-container {
        background: #f8fafc;
        background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
        background-size: 24px 24px;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif;
    }

    .modern-khqr-card {
        background: var(--glass-bg);
        border-radius: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Branding Header */
    .card-branding-top {
        background: #000000;
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }
    .bakong-logo-wrap img { height: 20px; filter: brightness(0) invert(1); }
    .khqr-pill {
        background: #ffffff; color: #000; padding: 2px 8px;
        border-radius: 4px; font-weight: 800; font-size: 0.7rem; margin-left: 8px;
    }
    .live-status { display: flex; align-items: center; font-size: 0.7rem; opacity: 0.8; }
    .pulse-icon {
        width: 8px; height: 8px; background: #22c55e; border-radius: 50%;
        margin-right: 6px; box-shadow: 0 0 0 rgba(34, 197, 94, 0.4);
        animation: pulse 2s infinite;
    }

    /* Merchant Box */
    .merchant-profile-box { text-align: center; padding: 24px 24px 10px; }
    .merchant-avatar-wrapper { position: relative; width: 60px; height: 60px; margin: 0 auto 12px; }
    .avatar-inner {
        width: 100%; height: 100%; background: linear-gradient(135deg, var(--khqr-primary), #9f1239);
        border-radius: 18px; display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 1.4rem;
    }
    .verified-badge {
        position: absolute; bottom: -4px; right: -4px; background: #3b82f6;
        color: white; width: 20px; height: 20px; border-radius: 50%;
        font-size: 0.6rem; display: flex; align-items: center; justify-content: center;
        border: 2px solid white;
    }

    /* Price Area */
    .price-container { margin-bottom: 15px; }
    .price-tag-large { color: var(--khqr-dark); font-weight: 800; line-height: 1; }
    .currency-symbol { font-size: 1.4rem; vertical-align: super; color: var(--khqr-primary); margin-right: 2px; }
    .amount-val { font-size: 3.2rem; letter-spacing: -2px; }
    
    .free-shipping-tag {
        background: var(--success-soft); color: var(--success-deep);
        font-size: 0.75rem; font-weight: 700; padding: 4px 12px;
        border-radius: 20px; display: inline-block; margin-top: 8px;
    }

    .payment-summary-box {
        background: #f8fafc; border-radius: 16px; padding: 12px 20px;
        margin-top: 15px; border: 1px solid #f1f5f9;
    }
    .summary-item { display: flex; justify-content: space-between; font-size: 0.85rem; color: #64748b; }
    .summary-divider { height: 1px; background: #e2e8f0; margin: 8px 0; }

    /* QR Code Area */
    .qr-scanner-visual { display: flex; flex-direction: column; align-items: center; padding: 10px 0 20px; }
    .qr-box-container {
        position: relative; padding: 12px; background: white;
        border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .qr-image-wrap { width: 190px; height: 190px; overflow: hidden; border-radius: 12px; position: relative; }
    .qr-image-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .qr-overlay-logo {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: white; padding: 6px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        color: var(--khqr-primary); font-size: 1.2rem;
    }
    
    .scanner-line {
        position: absolute; width: calc(100% - 24px); height: 2px;
        background: var(--khqr-primary); box-shadow: 0 0 12px var(--khqr-primary);
        top: 12px; left: 12px; z-index: 10; animation: scan-move 3s linear infinite;
    }
    .qr-corner { position: absolute; width: 25px; height: 25px; border: 3px solid #e2e8f0; z-index: 5; }
    .top-left { top: 0; left: 0; border-right: 0; border-bottom: 0; border-top-left-radius: 16px; }
    .top-right { top: 0; right: 0; border-left: 0; border-bottom: 0; border-top-right-radius: 16px; }
    .bottom-left { bottom: 0; left: 0; border-right: 0; border-top: 0; border-bottom-left-radius: 16px; }
    .bottom-right { bottom: 0; right: 0; border-left: 0; border-top: 0; border-bottom-right-radius: 16px; }

    .timer-display-modern {
        margin-top: 16px; color: #64748b; font-size: 0.85rem;
        display: flex; align-items: center; gap: 6px;
    }

    /* Banks Area */
    .supported-banks-area { text-align: center; padding: 0 24px 20px; }
    .small-title { font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
    .bank-chip { 
        font-size: 0.65rem; font-weight: 700; color: #475569; 
        background: #f1f5f9; padding: 4px 10px; border-radius: 6px; margin: 0 2px;
    }

    /* Action Buttons */
    .btn-confirm-pay {
        width: 100%; background: var(--khqr-dark); color: white; border: none;
        padding: 16px 20px; border-radius: 16px; font-weight: 700;
        display: flex; justify-content: space-between; align-items: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-confirm-pay:hover { background: #000; transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); }
    .btn-icon { background: rgba(255,255,255,0.1); width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }

    .link-cancel-payment { 
        display: block; text-align: center; margin-top: 16px; color: #94a3b8; 
        text-decoration: none; font-size: 0.85rem; font-weight: 600;
    }
    .link-cancel-payment:hover { color: var(--khqr-primary); }

    .footer-trust-labels {
        display: flex; justify-content: center; gap: 20px; margin-top: 24px;
        font-size: 0.75rem; color: #94a3b8;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    @keyframes scan-move { 0% { top: 12px; } 50% { top: 202px; } 100% { top: 12px; } }
</style>

<script>
    // Timer Logic
    let seconds = 60;
    const timerEl = document.getElementById('timer');
    const payBtn = document.getElementById('btn-pay');

    const countdown = setInterval(() => {
        seconds--;
        let min = Math.floor(seconds / 60);
        let sec = seconds % 60;
        timerEl.innerText = `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;

        if (seconds <= 20) {
            document.getElementById('timer-badge').style.color = 'var(--khqr-primary)';
        }

        if (seconds <= 0) {
            clearInterval(countdown);
            payBtn.disabled = true;
            payBtn.innerHTML = 'Expired';
            alert("Payment session expired.");
            window.location.href = "{{ route('home') }}";
        }
    }, 1000);

    // Form Loading Logic
    document.getElementById('payment-form').addEventListener('submit', function() {
        const btn = document.getElementById('btn-pay');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        btn.disabled = true;
        btn.style.opacity = '0.7';
    });
</script>
@endsection