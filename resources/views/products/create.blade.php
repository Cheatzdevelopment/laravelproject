@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row mb-5 animate__animated animate__fadeIn">
        <div class="col-md-8">
            <h2 class="fw-extra-bold text-dark mb-1">✨ បង្កើតទំនិញថ្មី</h2>
            <p class="text-muted small">បំពេញព័ត៌មានខាងក្រោមដើម្បីដាក់លក់ផលិតផលរបស់អ្នកក្នុងប្រព័ន្ធ (Edition 2026)</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('products.index') }}" class="btn btn-light rounded-pill px-4 fw-bold border shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> ត្រឡប់ក្រោយ
            </a>
        </div>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="needs-validation">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden mb-4 animate__animated animate__fadeInLeft">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary-subtle p-3 rounded-4 me-3 text-primary shadow-sm">
                                <i class="fas fa-pen-nib fa-xl"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">ព័ត៌មានមូលដ្ឋាន (Primary Details)</h5>
                        </div>

                        <div class="mb-4">
                            <label class="premium-label">ឈ្មោះទំនិញ (Product Name)</label>
                            <input type="text" name="name" class="premium-input @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="ឧ. កាហ្វេឡាតេ ក្តៅ/ត្រជាក់..." required autofocus>
                            @error('name') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="premium-label">ប្រភេទអាហារ (Category)</label>
                            <select name="category" class="premium-input @error('category') is-invalid @enderror" required>
                                <option value="" disabled selected>ជ្រើសរើសប្រភេទ...</option>
                                <option value="អាហារពេលព្រឹក" {{ old('category') == 'អាហារពេលព្រឹក' ? 'selected' : '' }}>🥐 អាហារពេលព្រឹក</option>
                                <option value="អាហារថ្ងៃត្រង់" {{ old('category') == 'អាហារថ្ងៃត្រង់' ? 'selected' : '' }}>🍱 អាហារថ្ងៃត្រង់</option>
                                <option value="ភេសជ្ជៈ" {{ old('category') == 'ភេសជ្ជៈ' ? 'selected' : '' }}>☕ ភេសជ្ជៈ</option>
                            </select>
                            @error('category') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="premium-label">តម្លៃលក់ (Price USD)</label>
                                <div class="input-container-premium">
                                    <span class="currency-symbol">$</span>
                                    <input type="number" step="0.01" name="price" class="premium-input-icon @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" placeholder="0.00" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block fw-bold">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="premium-label">ចំនួនក្នុងស្តុក (Initial Stock)</label>
                                <div class="input-container-premium">
                                    <span class="currency-symbol"><i class="fas fa-box"></i></span>
                                    <input type="number" name="stock" class="premium-input-icon @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock') }}" placeholder="0" required>
                                </div>
                                @error('stock') <div class="invalid-feedback d-block fw-bold">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="premium-label">ការពិពណ៌នា (Description)</label>
                            <textarea name="description" class="premium-input" rows="4" 
                                      placeholder="រៀបរាប់ពីលក្ខណៈពិសេសរបស់ទំនិញ... (Optional)">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-5 mb-4 overflow-hidden animate__animated animate__fadeInRight">
                    <div class="card-header bg-white p-4 border-0 pb-0 text-center">
                        <h6 class="fw-extra-bold text-dark mb-0 text-uppercase small" style="letter-spacing: 1px;">រូបភាពផលិតផល</h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <label for="image" class="image-upload-zone" id="dropZone">
                            <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                            <div id="preview-placeholder">
                                <div class="upload-icon mb-3">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary opacity-50"></i>
                                </div>
                                <p class="fw-bold text-dark mb-1">អូសរូបភាពដាក់ទីនេះ</p>
                                <p class="text-muted x-small">ឬចុចដើម្បីជ្រើសរើស (Max: 5MB)</p>
                            </div>
                            <img id="imagePreview" src="#" class="d-none w-100 h-100 object-fit-cover rounded-4">
                            
                            <button type="button" id="removeImg" class="btn btn-danger btn-sm rounded-circle d-none shadow" 
                                    onclick="clearPreview(event)">
                                <i class="fas fa-times"></i>
                            </button>
                        </label>
                        @error('image') <div class="text-danger small mt-2 fw-bold">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="card border-0 shadow-lg rounded-5 bg-dark text-white p-2 animate__animated animate__fadeInUp">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 p-3 rounded-pill d-inline-block mb-3">
                            <i class="fas fa-rocket text-primary fa-lg"></i>
                        </div>
                        <h5 class="fw-bold">បោះពុម្ពផ្សាយទំនិញ</h5>
                        <p class="text-white-50 small mb-4">ផលិតផលនឹងបង្ហាញក្នុងបញ្ជីភ្លាមៗ បន្ទាប់ពីរក្សាទុក។</p>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-4 fw-bold py-3 shadow-lg transition-btn">
                                <i class="fas fa-check-circle me-2"></i> រក្សាទុកទំនិញថ្មី
                            </button>
                            <button type="reset" class="btn btn-link text-white text-decoration-none opacity-50 small fw-bold mt-2" onclick="location.reload()">
                                <i class="fas fa-undo me-1"></i> កំណត់ឡើងវិញ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    :root { --primary: #4f46e5; --primary-soft: #EEF2FF; }
    .fw-extra-bold { font-weight: 800; }
    
    .premium-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 0.75rem; display: block; letter-spacing: 0.5px; }

    .premium-input, .premium-input-icon {
        width: 100%; padding: 16px 20px; background: #f1f5f9; border: 2px solid transparent;
        border-radius: 18px; font-weight: 600; color: #1e293b; transition: all 0.3s;
    }
    .premium-input:focus, .premium-input-icon:focus { background: #fff; border-color: var(--primary); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.08); outline: none; }
    
    /* Custom style for Select Box arrow */
    select.premium-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 1.5em;
    }

    .premium-input-icon { padding-left: 45px; font-weight: 700; }
    .input-container-premium { position: relative; display: flex; align-items: center; }
    .currency-symbol { position: absolute; left: 20px; font-weight: 800; color: var(--primary); }

    .image-upload-zone {
        width: 100%; height: 280px; background: #f8fafc; border: 3px dashed #e2e8f0;
        border-radius: 30px; display: flex; flex-direction: column; align-items: center;
        justify-content: center; cursor: pointer; transition: all 0.3s; position: relative; overflow: hidden;
    }
    .image-upload-zone:hover { border-color: var(--primary); background: var(--primary-soft); transform: scale(1.01); }
    #removeImg { position: absolute; top: 15px; right: 15px; z-index: 10; }

    .transition-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(79, 70, 229, 0.3) !important; }
    .bg-primary-subtle { background-color: var(--primary-soft); }
    .text-primary { color: var(--primary) !important; }
    .x-small { font-size: 11px; }
    .is-invalid { border-color: #ef4444 !important; background-color: #fef2f2 !important; }
</style>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            const output = document.getElementById('imagePreview');
            const placeholder = document.getElementById('preview-placeholder');
            const removeBtn = document.getElementById('removeImg');
            const dropZone = document.getElementById('dropZone');

            reader.onload = function() {
                output.src = reader.result;
                output.classList.remove('d-none');
                placeholder.classList.add('d-none');
                removeBtn.classList.remove('d-none');
                dropZone.style.borderStyle = 'solid';
            };
            reader.readAsDataURL(file);
        }
    }

    function clearPreview(event) {
        event.stopPropagation();
        const fileInput = document.getElementById('image');
        const output = document.getElementById('imagePreview');
        const placeholder = document.getElementById('preview-placeholder');
        const removeBtn = document.getElementById('removeImg');
        const dropZone = document.getElementById('dropZone');

        fileInput.value = "";
        output.src = "#";
        output.classList.add('d-none');
        placeholder.classList.remove('d-none');
        removeBtn.classList.add('d-none');
        dropZone.style.borderStyle = 'dashed';
    }
</script>
@endsection