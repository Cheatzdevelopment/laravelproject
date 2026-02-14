@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-800 text-dark mb-1">គណនីរបស់ខ្ញុំ</h2>
                    <p class="text-muted small mb-0">គ្រប់គ្រងព័ត៌មានផ្ទាល់ខ្លួន និងរូបភាព Profile</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-white border rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fas fa-home me-2"></i> ទៅកាន់ទំព័រដើម
                </a>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
                            <div style="height: 100px; background: linear-gradient(45deg, #4f46e5, #818cf8);"></div>
                            <div class="card-body text-center" style="margin-top: -60px;">
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="avatar-wrapper shadow-lg">
                                        @if($user->avatar)
                                            <img id="avatarPreview" src="{{ asset('storage/'.$user->avatar) }}" class="avatar-img">
                                        @else
                                            <div id="avatarPlaceholder" class="avatar-initials">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <img id="avatarPreview" src="" class="avatar-img d-none">
                                        @endif
                                    </div>
                                    <label for="avatarInput" class="btn-edit-avatar" title="ប្តូររូបភាព">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    @if($user->avatar)
                                        <button type="button" onclick="confirmDeleteAvatar()" class="btn-delete-avatar" title="លុបរូបភាព">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                    <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*" onchange="previewImage(event)">
                                </div>
                                <h5 class="fw-800 mb-0">{{ $user->name }}</h5>
                                <p class="text-muted small">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-5 p-4">
                            <h6 class="fw-800 mb-4 text-primary text-uppercase" style="letter-spacing: 1px;">ព័ត៌មានទូទៅ</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">ឈ្មោះពេញ</label>
                                    <input type="text" name="name" class="form-control premium-input" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">អ៊ីមែល</label>
                                    <input type="email" name="email" class="form-control premium-input" value="{{ $user->email }}" required>
                                </div>
                                <div class="col-12 mt-4">
                                    <h6 class="fw-800 mb-3 text-danger text-uppercase" style="letter-spacing: 1px;">ប្តូរពាក្យសម្ងាត់</h6>
                                </div>
                                <div class="col-12">
                                    <label class="small fw-bold text-muted">ពាក្យសម្ងាត់បច្ចុប្បន្ន</label>
                                    <input type="password" name="current_password" class="form-control premium-input" placeholder="ទុកឱ្យនៅទទេ បើមិនចង់ប្តូរ">
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">ពាក្យសម្ងាត់ថ្មី</label>
                                    <input type="password" name="new_password" class="form-control premium-input">
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី</label>
                                    <input type="password" name="new_password_confirmation" class="form-control premium-input">
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold w-100 shadow">
                                    រក្សាទុកការផ្លាស់ប្តូរ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="deleteAvatarForm" action="{{ route('profile.avatar.delete') }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>

<style>
    .fw-800 { font-weight: 800; }
    .avatar-wrapper { width: 120px; height: 120px; border-radius: 35px; background: white; padding: 5px; overflow: hidden; display: inline-block; border: 4px solid white; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; border-radius: 30px; }
    .avatar-initials { width: 100%; height: 100%; border-radius: 30px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; }
    .btn-edit-avatar, .btn-delete-avatar { position: absolute; width: 35px; height: 35px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: none; }
    .btn-edit-avatar { bottom: -5px; right: -5px; background: #4f46e5; color: white; }
    .btn-delete-avatar { bottom: -5px; left: -5px; background: #fee2e2; color: #ef4444; }
    .premium-input { border-radius: 15px; border: 2px solid #f1f5f9; padding: 12px 20px; font-weight: 600; }
    .premium-input:focus { border-color: #4f46e5; box-shadow: none; background: #fafbff; }
</style>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
            output.classList.remove('d-none');
            document.getElementById('avatarPlaceholder')?.classList.add('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function confirmDeleteAvatar() {
        Swal.fire({
            title: 'លុបរូបភាព?',
            text: "តើអ្នកប្រាកដថាចង់លុបរូបភាព Profile នេះមែនទេ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#d33',
            confirmButtonText: 'បាទ លុបវា!',
            cancelButtonText: 'បោះបង់'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('deleteAvatarForm').submit();
        });
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'ជោគជ័យ', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
</script>
@endsection