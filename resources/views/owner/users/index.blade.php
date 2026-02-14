@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid px-4 py-5" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-extra-bold text-dark mb-1">👥 គ្រប់គ្រងបុគ្គលិក និងការចូលប្រើប្រាស់</h2>
            <p class="text-muted small mb-0">Manage team members, roles, and security permissions.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex bg-white p-2 rounded-pill shadow-sm border border-light">
                <div class="px-3 border-end">
                    <span class="d-block x-small text-muted fw-bold">ADMINS</span>
                    <span class="fw-bold text-danger">{{ $users->where('role', 'admin')->count() }}</span>
                </div>
                <div class="px-3">
                    <span class="d-block x-small text-muted fw-bold">STAFF</span>
                    <span class="fw-bold text-primary">{{ $users->where('role', 'cashier')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-dark p-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary p-2 rounded-3 me-3 text-white">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">ចុះឈ្មោះបុគ្គលិក</h5>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('owner.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="premium-label">ឈ្មោះពេញ (Full Name)</label>
                            <div class="premium-input-group">
                                <i class="fas fa-id-badge icon-left"></i>
                                <input type="text" name="name" class="premium-input-icon" placeholder="Enter full name" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="premium-label">អ៊ីមែល (Email Address)</label>
                            <div class="premium-input-group">
                                <i class="fas fa-at icon-left"></i>
                                <input type="email" name="email" class="premium-input-icon" placeholder="staff@company.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="premium-label">កំណត់ពាក្យសម្ងាត់ (Password)</label>
                            <div class="premium-input-group">
                                <i class="fas fa-key icon-left"></i>
                                <input type="password" name="password" class="premium-input-icon" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="premium-label">តួនាទី (System Role)</label>
                            <div class="role-selector-grid">
                                <input type="radio" name="role" value="cashier" id="roleCashier" checked class="d-none">
                                <label for="roleCashier" class="role-card">
                                    <i class="fas fa-cash-register d-block mb-2"></i>
                                    Cashier
                                </label>

                                <input type="radio" name="role" value="admin" id="roleAdmin" class="d-none">
                                <label for="roleAdmin" class="role-card">
                                    <i class="fas fa-user-shield d-block mb-2"></i>
                                    Admin
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-4 fw-bold py-3 shadow-lg transition-btn">
                            <i class="fas fa-save me-2"></i> បង្កើតគណនីថ្មី
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
                <div class="card-header bg-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="fw-extra-bold text-dark mb-0">បញ្ជីឈ្មោះសមាជិកក្រុម</h5>
                        </div>
                        <div class="col-md-6 text-md-end mt-2 mt-md-0">
                            <div class="search-box-pill px-3 py-2 bg-light d-inline-flex align-items-center rounded-pill">
                                <i class="fas fa-search text-muted me-2"></i>
                                <input type="text" class="border-0 bg-transparent small fw-bold" placeholder="ស្វែងរកបុគ្គលិក..." style="outline: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr class="text-muted small text-uppercase fw-800">
                                    <th class="ps-4 py-3">User Profile</th>
                                    <th>Access Level</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center py-2">
                                            @php
                                                $gradients = [
                                                    'admin' => 'linear-gradient(135deg, #ef4444, #991b1b)',
                                                    'cashier' => 'linear-gradient(135deg, #6366f1, #4338ca)',
                                                    'owner' => 'linear-gradient(135deg, #1e293b, #0f172a)',
                                                    'user' => 'linear-gradient(135deg, #94a3b8, #64748b)'
                                                ];
                                                $bg = $gradients[$user->role] ?? $gradients['user'];
                                            @endphp
                                            <div class="avatar-premium me-3 shadow-sm" style="background: {{ $bg }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-extra-bold text-dark mb-0">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->role == 'owner')
                                            <span class="badge-role role-owner"><i class="fas fa-crown me-1"></i> Owner</span>
                                        @elseif($user->role == 'admin')
                                            <span class="badge-role role-admin"><i class="fas fa-shield-alt me-1"></i> Admin</span>
                                        @else
                                            <span class="badge-role role-staff"><i class="fas fa-user me-1"></i> Staff</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-success small fw-bold">
                                            <span class="pulse-green me-2"></span> Active
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($user->role != 'owner')
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle p-0" style="width: 32px; height: 32px;" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                                                    <li><a class="dropdown-item rounded-3 small fw-bold py-2" href="#"><i class="fas fa-edit me-2 text-warning"></i> កែប្រែសិទ្ធ</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('owner.users.delete', $user->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="dropdown-item rounded-3 small fw-bold py-2 text-danger" onclick="return confirm('លុបអ្នកប្រើប្រាស់នេះ?')">
                                                                <i class="fas fa-trash-alt me-2"></i> លុបចេញ
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @else
                                            <i class="fas fa-lock text-muted opacity-50"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #4f46e5;
        --danger: #ef4444;
    }

    .fw-extra-bold { font-weight: 800; }
    .fw-800 { font-weight: 800; }
    .x-small { font-size: 10px; }

    /* Premium Inputs */
    .premium-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 0.8rem;
        display: block;
        letter-spacing: 0.5px;
    }

    .premium-input-group { position: relative; display: flex; align-items: center; }
    .icon-left { position: absolute; left: 18px; color: #94a3b8; font-size: 1.1rem; }
    
    .premium-input-icon {
        width: 100%;
        padding: 14px 20px 14px 50px;
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .premium-input-icon:focus {
        background: #fff;
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.05);
    }

    /* Role Selector Cards */
    .role-selector-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .role-card {
        padding: 15px;
        border: 2px solid #f1f5f9;
        border-radius: 15px;
        text-align: center;
        cursor: pointer;
        font-weight: 700;
        color: #64748b;
        transition: all 0.3s;
    }
    input[type="radio"]:checked + .role-card {
        background: #EEF2FF;
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Avatars & Badges */
    .avatar-premium {
        width: 45px;
        height: 45px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 1.2rem;
    }

    .badge-role {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
    }
    .role-owner { background: #1e293b; color: #f8fafc; }
    .role-admin { background: #fee2e2; color: #b91c1c; }
    .role-staff { background: #e0e7ff; color: #4338ca; }

    /* Pulse Effect */
    .pulse-green {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .bg-light-subtle { background-color: #f8fafc; }
    .rounded-5 { border-radius: 2rem !important; }
    .transition-btn:hover { transform: translateY(-3px); }
</style>
@endsection