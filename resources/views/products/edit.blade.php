@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row align-items-center mb-5 animate__animated animate__fadeIn">
        <div class="col-md-7">
            <h2 class="fw-extra-bold text-dark mb-1">✏️ កែប្រែព័ត៌មានទំនិញ</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted small fw-bold text-uppercase">Inventory</a></li>
                    <li class="breadcrumb-item active text-primary small fw-bold" aria-current="page">EDIT ID: #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="{{ route('products.index') }}" class="btn btn-white border rounded-pill px-4 fw-bold shadow-sm transition-btn">
                <i class="fas fa-chevron-left me-2 text-muted"></i> ត្រឡប់ក្រោយ
            </a>
        </div>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden animate__animated animate__fadeInLeft">
                    <div class="card-header bg-white p-4 border-0 d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-4 me-3 text-primary shadow-sm">
                            <i class="fas fa-sliders-h fa-xl"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">ព័ត៌មានលម្អិត (Product Specification)</h5>
                            <p class="text-muted small mb-0">កែប្រែព័ត៌មានបច្ចេកទេស តម្លៃ និងប្រភេទទំនិញ</p>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 pt-0">
                        <div class="mb-4">
                            <label class="premium-label">ឈ្មោះទំនិញ (Product Name)</label>
                            <input type="text" name="name" class="premium-input @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="premium-label">ប្រភេទអាហារ (Category)</label>
                            <select name="category" class="premium-input @error('category') is-invalid @enderror" required>
                                <option value="" disabled>ជ្រើសរើសប្រភេទ...</option>
                                <option value="អាហារពេលព្រឹក" {{ old('category', $product->category) == 'អាហារពេលព្រឹក' ? 'selected' : '' }}>🥐 អាហារពេលព្រឹក</option>
                                <option value="អាហារថ្ងៃត្រង់" {{ old('category', $product->category) == 'អាហារថ្ងៃត្រង់' ? 'selected' : '' }}>🍱 អាហារថ្ងៃត្រង់</option>
                                <option value="ភេសជ្ជៈ" {{ old('category', $product->category) == 'ភេសជ្ជៈ' ? 'selected' : '' }}>☕ ភេសជ្ជៈ</option>
                            </select>
                            @error('category') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="premium-label">តម្លៃបច្ចុប្បន្ន (Price USD)</label>
                                <div class="input-container-premium">
                                    <span class="currency-symbol">$</span>
                                    <input type="number" step="0.01" name="price" class="premium-input-icon fw-extra-bold text-primary @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $product->price) }}" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block fw-bold">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="premium-label">ចំនួនក្នុងស្តុក (Inventory Level)</label>
                                <div class="input-container-premium">
                                    <span class="currency-symbol"><i class="fas fa-boxes"></i></span>
                                    <input type="number" name="stock" class="premium-input-icon @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', $product->stock) }}" required>
                                </div>
                                @error('stock') <div class="invalid-feedback d-block fw-bold">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="premium-label">ការពិពណ៌នាទំនិញ (Description)</label>
                            <textarea name="description" class="premium-input" rows="5">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-5 mb-4 overflow-hidden animate__animated animate__fadeInRight">
                    <div class="card-header bg-light p-4 border-0 text-center">
                        <h6 class="fw-extra-bold text-dark mb-0 text-uppercase small" style="letter-spacing: 1px;">រូបភាពទំនិញ</h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="image-edit-container mb-4 shadow-sm border rounded-5 overflow-hidden">
                            <img id="imagePreview" 
                                 src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/400?text=No+Image' }}" 
                                 class="w-100 object-fit-cover" 
                                 style="height: 280px;">
                            
                            <div class="stock-status-pill">
                                @if($product->stock > 5)
                                    <span class="badge bg-success rounded-pill px-3 py-2 border border-2 border-white shadow-sm"><i class="fas fa-check-circle me-1"></i> Active</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 border border-2 border-white shadow-sm"><i class="fas fa-exclamation-triangle me-1"></i> Low Stock</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2 border border-2 border-white shadow-sm"><i class="fas fa-times-circle me-1"></i> Sold Out</span>
                                @endif
                            </div>
                        </div>

                        <label for="image" class="btn btn-primary-soft w-100 py-3 rounded-4 fw-bold mb-2 cursor-pointer transition-btn">
                            <i class="fas fa-camera-retro me-2"></i> ផ្លាស់ប្តូររូបភាព
                        </label>
                        <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                        <p class="text-muted x-small mb-0 mt-2">JPG, PNG ឬ WEBP (ទំហំសមាមាត្រ 1:1 ល្អបំផុត)</p>
                    </div>
                </div>

                <div class="card border-0 shadow-lg rounded-5 bg-dark text-white p-2 animate__animated animate__fadeInUp">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 p-3 rounded-pill d-inline-block mb-3">
                            <i class="fas fa-save text-primary fa-lg"></i>
                        </div>
                        <h5 class="fw-bold">រក្សាទុកការកែប្រែ</h5>
                        <p class="text-white-50 small mb-4">ការផ្លាស់ប្តូរនឹងធ្វើបច្ចុប្បន្នភាពក្នុងបញ្ជីភ្លាមៗ។</p>
                        
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-4 fw-bold py-3 shadow-lg transition-btn">
                                <i class="fas fa-sync-alt me-2"></i> រក្សាទុកទិន្នន័យ
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-link text-white text-decoration-none opacity-50 small fw-bold">
                                <i class="fas fa-times me-1"></i> បោះបង់
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    :root { --primary: #4f46e5; --primary-soft: #f0f1ff; }
    .fw-extra-bold { font-weight: 800; }
    
    .premium-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; margin-bottom: 0.8rem; display: block; letter-spacing: 1px; }

    .premium-input, .premium-input-icon {
        width: 100%; padding: 16px 20px; background: #f8fafc; border: 2px solid #e2e8f0;
        border-radius: 20px; font-weight: 600; color: #1e293b; transition: all 0.3s ease;
    }
    .premium-input:focus, .premium-input-icon:focus { background: #fff; border-color: var(--primary); box-shadow: 0 10px 25px rgba(79, 70, 229, 0.1); outline: none; }

    select.premium-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 1.5em;
    }

    .input-container-premium { position: relative; display: flex; align-items: center; }
    .currency-symbol { position: absolute; left: 20px; font-weight: 800; color: var(--primary); }
    .premium-input-icon { padding-left: 45px; }

    .image-edit-container { position: relative; border-radius: 30px; }
    .stock-status-pill { position: absolute; top: 15px; right: 15px; z-index: 5; }

    .btn-primary-soft { background: var(--primary-soft); color: var(--primary); border: none; }
    .btn-primary-soft:hover { background: var(--primary); color: white; }
    .btn-white { background-color: #fff; border: none; }
    
    .transition-btn { transition: all 0.3s; cursor: pointer; }
    .transition-btn:hover { transform: translateY(-3px); }

    .bg-primary-subtle { background-color: var(--primary-soft); }
    .text-primary { color: var(--primary) !important; }
    .x-small { font-size: 11px; }
    .rounded-5 { border-radius: 2rem !important; }
    .rounded-4 { border-radius: 1.2rem !important; }
    .is-invalid { border-color: #ef4444 !important; }
</style>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const output = document.getElementById('imagePreview');

        reader.onload = function(){
            output.src = reader.result;
            output.animate([
                { opacity: 0, transform: 'scale(0.9)' },
                { opacity: 1, transform: 'scale(1)' }
            ], { duration: 500, easing: 'ease-out' });
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection