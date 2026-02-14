@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

<div class="shop-wrapper main-scroll-container">
    
    <nav class="status-bar-2026 sticky-top border-bottom">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="d-flex align-items-center gap-3">
                <div class="live-pulse">
                    <span class="pulse-ring"></span>
                    <span class="pulse-dot"></span>
                </div>
                <span class="small fw-bold text-success text-uppercase tracking-wider">ហាងបើកដំណើរការ</span>
                <span class="v-divider"></span>
                <span class="small text-muted d-none d-md-flex align-items-center">
                    <i class="far fa-bolt me-2 text-warning"></i> ដឹកជញ្ជូនរហ័ស: <b>១៥-២៥ នាទី</b>
                </span>
            </div>
            <div class="social-glass">
                <a href="#" class="glass-icon"><i class="fab fa-telegram-plane"></i></a>
                <a href="#" class="glass-icon"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="swiper promoSlider mb-5 rounded-5 shadow-2xl" data-aos="fade-down">
            <div class="swiper-wrapper">
                <div class="swiper-slide promo-card s1">
                    <div class="promo-overlay"></div>
                    <div class="promo-content-wrapper">
                        <div class="promo-tag animate__animated animate__fadeInLeft">SPECIAL OFFER</div>
                        <h2 class="promo-title">បញ្ចុះតម្លៃ <span class="text-highlight">៥០%</span><br>លើការកម្មង់ដំបូង!</h2>
                        <button class="btn-premium-light mt-3">កម្មង់ឥឡូវនេះ <i class="fas fa-chevron-right ms-2"></i></button>
                    </div>
                    <div class="promo-visual">
                        <img src="https://img.freepik.com/free-photo/delicious-burger-with-fresh-ingredients_23-2150857908.jpg" class="floating-img">
                    </div>
                </div>
                
                <div class="swiper-slide promo-card s2">
                    <div class="promo-overlay"></div>
                    <div class="promo-content-wrapper">
                        <div class="promo-tag tag-warning">NEW ARRIVAL</div>
                        <h2 class="promo-title">កាហ្វេប្រចាំត្រកូល<br><span class="text-highlight">ឈ្ងុយប្លែកគេ</span></h2>
                        <button class="btn-premium-warning mt-3">សាកល្បង <i class="fas fa-mug-hot ms-2"></i></button>
                    </div>
                    <div class="promo-visual">
                        <img src="https://img.freepik.com/free-photo/hot-coffee-cup-table-cafe_1150-12151.jpg" class="floating-img">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination custom-pagination"></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="search-hero-glass mb-4 p-4" data-aos="fade-up">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-3 mb-md-0">
                            <h4 class="fw-800 text-dark mb-1">ស្វែងរករសជាតិថ្មី</h4>
                            <p class="text-muted small mb-0">ម្ហូប និងភេសជ្ជៈជម្រើសពិសេសសម្រាប់អ្នក</p>
                        </div>
                        <div class="col-md-5">
                            <div class="modern-input-group">
                                <i class="fas fa-search"></i>
                                <input type="text" id="productSearch" placeholder="ស្វែងរកម្ហូបក្នុងក្តីស្រមៃ...">
                                <span class="input-glow"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="category-nav mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="category-scroll-wrapper scroll-hide">
                        <button class="cat-pill-modern active" onclick="filterCategory('all', this)">ទាំងអស់</button>
                        <button class="cat-pill-modern" onclick="filterCategory('អាហារពេលព្រឹក', this)">🥐 អាហារពេលព្រឹក</button>
                        <button class="cat-pill-modern" onclick="filterCategory('អាហារថ្ងៃត្រង់', this)">🍱 អាហារថ្ងៃត្រង់</button>
                        <button class="cat-pill-modern" onclick="filterCategory('ភេសជ្ជៈ', this)">☕ ភេសជ្ជៈ</button>
                    </div>
                </div>

                <div class="row g-4" id="productGrid">
                    @forelse($products as $product)
                    <div class="col-md-6 col-xl-4 product-item" data-category="{{ $product->category }}" data-aos="zoom-in-up">
                        <div class="product-card-premium">
                            <div class="image-box">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                <div class="price-tag shadow-sm">${{ number_format($product->price, 2) }}</div>
                                <div class="floating-status">{!! $product->stock_status !!}</div>
                            </div>

                            <div class="content-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="cat-label">{{ $product->category }}</span>
                                    <span class="rating-badge"><i class="fas fa-star"></i> 4.9</span>
                                </div>
                                <h6 class="product-title">{{ $product->name }}</h6>
                                <p class="product-desc line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="action-footer mt-auto">
                                    @if($product->stock > 0)
                                        <div class="qty-stepper">
                                            <button onclick="changeQty('{{ $product->id }}', -1)">-</button>
                                            <span id="qty-display-{{ $product->id }}">1</span>
                                            <button onclick="changeQty('{{ $product->id }}', 1)">+</button>
                                        </div>
                                        
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" id="qty-input-{{ $product->id }}" value="1">
                                            <button type="submit" class="btn-cart-premium" onclick="triggerConfetti(event)">
                                                <i class="fas fa-shopping-bag"></i>
                                            </button>
                                        </form>
                                    @else
                                        <div class="out-stock-label">អស់ស្តុកបណ្តោះអាសន្ន</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-sticky-wrapper" data-aos="fade-left">
                    <div class="cart-card-modern">
                        <div class="cart-header">
                            <h5 class="m-0 fw-800"><i class="fas fa-shopping-basket me-2"></i>កន្ត្រកទំនិញ</h5>
                            <span class="item-count">{{ $cartItems->count() }}</span>
                        </div>
                        
                        <div class="cart-list scroll-hide">
                            @forelse($cartItems as $item)
                            <div class="cart-item-row">
                                <div class="item-thumb">
                                    <img src="{{ asset('storage/'.$item->product->image) }}" onerror="this.src='https://via.placeholder.com/50'">
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $item->product->name }}</div>
                                    <div class="item-meta">
                                        <span class="p-val">${{ number_format($item->product->price, 2) }}</span>
                                        <span class="x-sep">×</span>
                                        <span class="q-val">{{ $item->quantity }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </div>
                            @empty
                            <div class="empty-cart-ui py-5">
                                <div class="empty-icon animate__animated animate__pulse animate__infinite">🛒</div>
                                <p class="mt-3 small fw-bold text-muted">មិនទាន់មានទំនិញក្នុងកន្ត្រក</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="cart-summary">
                            <div class="summary-line">
                                <span>ដឹកជញ្ជូន</span>
                                <span class="free-ship">ឥតគិតថ្លៃ</span>
                            </div>
                            <div class="summary-line total">
                                <span>សរុបរួម</span>
                                <span class="total-price">${{ number_format($total, 2) }}</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn-checkout-premium">
                                <span>បន្តទៅកាន់ការទូទាត់</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Root Variables */
    :root {
        --prm-blue: #4F46E5;
        --prm-indigo: #6366f1;
        --glass: rgba(255, 255, 255, 0.85);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        --prm-grad: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
    }

    /* Animations */
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .shop-wrapper { background: #f8fafc; min-height: 100vh; overflow-x: hidden; }

    /* Modern Status Bar */
    .status-bar-2026 { background: var(--glass); backdrop-filter: blur(15px); z-index: 1050; }
    .live-pulse { position: relative; width: 12px; height: 12px; }
    .pulse-ring { position: absolute; width: 100%; height: 100%; background: #22c55e; border-radius: 50%; animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
    .pulse-dot { position: absolute; width: 8px; height: 8px; background: #22c55e; border-radius: 50%; top: 2px; left: 2px; }
    @keyframes pulse-ring { 0% { transform: scale(0.33); } 80%, 100% { opacity: 0; } }

    /* Promo Slider Premium */
    .promo-card { height: 320px; border-radius: 40px; display: flex; align-items: center; padding: 0 60px; position: relative; }
    .promo-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 60%); }
    .promo-content-wrapper { z-index: 5; color: white; }
    .promo-tag { background: rgba(255,255,255,0.2); backdrop-filter: blur(5px); padding: 5px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; display: inline-block; margin-bottom: 15px; }
    .promo-title { font-weight: 800; font-size: 2.8rem; line-height: 1.1; }
    .text-highlight { color: #facc15; }
    .promo-visual { position: absolute; right: 8%; width: 40%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .floating-img { width: 100%; max-height: 80%; object-fit: contain; animation: floating 4s ease-in-out infinite; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3)); }

    /* Search Bar Hero */
    .search-hero-glass { background: white; border-radius: 30px; border: 1px solid rgba(0,0,0,0.05); }
    .modern-input-group { position: relative; display: flex; align-items: center; }
    .modern-input-group i { position: absolute; left: 20px; color: var(--prm-blue); }
    .modern-input-group input { width: 100%; padding: 16px 20px 16px 50px; border-radius: 18px; border: 2px solid #f1f5f9; background: #f8fafc; font-weight: 600; outline: none; transition: 0.3s; }
    .modern-input-group input:focus { border-color: var(--prm-blue); background: white; box-shadow: 0 10px 20px rgba(79,70,229,0.1); }

    /* Category Navigation */
    .category-scroll-wrapper { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 5px; }
    .cat-pill-modern { padding: 12px 25px; border-radius: 50px; border: none; background: white; color: #64748b; font-weight: 700; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .cat-pill-modern:hover { transform: translateY(-3px); color: var(--prm-blue); }
    .cat-pill-modern.active { background: var(--prm-blue); color: white; box-shadow: 0 10px 15px rgba(79,70,229,0.3); }

    /* Premium Product Card */
    .product-card-premium { background: white; border-radius: 35px; overflow: hidden; height: 100%; transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; display: flex; flex-direction: column; border: 1px solid #f1f5f9; }
    .product-card-premium:hover { transform: translateY(-15px) scale(1.02); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.12); }
    .image-box { position: relative; height: 200px; padding: 15px; }
    .image-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 25px; transition: 0.5s; }
    .product-card-premium:hover .image-box img { transform: scale(1.08); }
    .price-tag { position: absolute; top: 25px; right: 25px; background: white; padding: 6px 15px; border-radius: 15px; font-weight: 800; color: var(--prm-blue); z-index: 10; }

    .content-box { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .cat-label { font-size: 0.65rem; font-weight: 800; text-uppercase; color: var(--prm-blue); opacity: 0.7; }
    .rating-badge { font-size: 0.7rem; font-weight: 700; color: #f59e0b; }
    .product-title { font-weight: 800; color: #1e293b; margin: 5px 0; font-size: 1.05rem; }
    .product-desc { font-size: 0.8rem; color: #64748b; margin-bottom: 20px; }

    /* Action Buttons */
    .action-footer { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .qty-stepper { display: flex; align-items: center; background: #f1f5f9; border-radius: 15px; padding: 5px; }
    .qty-stepper button { border: none; background: white; width: 32px; height: 32px; border-radius: 12px; font-weight: 800; transition: 0.2s; }
    .qty-stepper button:hover { background: var(--prm-blue); color: white; }
    .qty-stepper span { margin: 0 15px; font-weight: 800; width: 15px; text-align: center; }
    .btn-cart-premium { width: 45px; height: 45px; border-radius: 15px; border: none; background: var(--prm-grad); color: white; transition: 0.3s; box-shadow: 0 8px 15px rgba(79,70,229,0.3); }
    .btn-cart-premium:hover { transform: rotate(15deg) scale(1.1); }

    /* Cart Modern */
    .cart-card-modern { background: white; border-radius: 35px; border: 1px solid #f1f5f9; box-shadow: var(--shadow-2xl); padding: 25px; position: sticky; top: 90px; }
    .cart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .item-count { background: #f1f5f9; padding: 5px 15px; border-radius: 50px; font-weight: 800; color: var(--prm-blue); font-size: 0.8rem; }
    .cart-list { max-height: 400px; overflow-y: auto; margin-bottom: 25px; }
    .cart-item-row { display: flex; align-items: center; gap: 15px; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px dashed #f1f5f9; }
    .item-thumb { width: 55px; height: 55px; border-radius: 15px; overflow: hidden; }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .item-name { font-weight: 700; font-size: 0.85rem; color: #1e293b; }
    .item-meta { font-size: 0.8rem; font-weight: 600; }
    .p-val { color: var(--prm-blue); }
    .btn-del { border: none; background: transparent; color: #ef4444; opacity: 0.3; transition: 0.3s; }
    .btn-del:hover { opacity: 1; transform: scale(1.2); }

    .btn-checkout-premium { background: #1e293b; color: white; padding: 20px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; text-decoration: none; font-weight: 800; transition: 0.3s; }
    .btn-checkout-premium:hover { background: #000; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); color: white; }

    /* Utilities */
    .scroll-hide::-webkit-scrollbar { display: none; }
    .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .tracking-wider { letter-spacing: 1px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    // ១. Initialize AOS (Scroll Animation)
    AOS.init({ duration: 800, once: true });

    // ២. Initialize Swiper
    const swiper = new Swiper('.promoSlider', {
        loop: true,
        parallax: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.swiper-pagination', clickable: true },
        effect: 'creative',
        creativeEffect: {
            prev: { shadow: true, translate: ['-20%', 0, -1] },
            next: { translate: ['100%', 0, 0] },
        },
    });

    // ៣. Product Counter Logic
    function changeQty(productId, delta) {
        const display = document.getElementById('qty-display-' + productId);
        const input = document.getElementById('qty-input-' + productId);
        let current = parseInt(display.innerText);
        let newValue = current + delta;
        if (newValue >= 1 && newValue <= 10) {
            display.innerText = newValue;
            input.value = newValue;
            // Add a small scale animation
            display.style.transform = "scale(1.3)";
            setTimeout(() => display.style.transform = "scale(1)", 100);
        }
    }

    // ៤. Search & Filter Integration
    function filterCategory(category, element) {
        document.querySelectorAll('.cat-pill-modern').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        
        document.querySelectorAll('.product-item').forEach(item => {
            const match = (category === 'all' || item.dataset.category === category);
            item.style.display = match ? 'block' : 'none';
        });
        AOS.refresh();
    }

    document.getElementById('productSearch').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.querySelector('.product-title').innerText.toLowerCase();
            item.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    function triggerConfetti(e) {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#4F46E5', '#7C3AED', '#22c55e']
        });
    }
</script>
@endsection
