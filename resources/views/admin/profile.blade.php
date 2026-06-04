@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Profil Admin')
@section('page-subtitle', 'Kelola informasi akun admin klinik')
@section('active-menu', 'profile')

@section('content')
<div class="profile-content">
    <div class="profile-grid">

        <!-- INFORMASI AKUN -->
        <div class="panel">
            <div class="panel-head green">
                <div class="head-icon">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="22" r="12"></circle>
                        <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                    </svg>
                </div>
                Informasi Akun
            </div>

            <div class="account-body">
                <div class="big-avatar">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="22" r="12"></circle>
                        <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                    </svg>
                </div>

                <div class="account-name">{{ auth()->user()->name ?? 'Admin Klinik' }}</div>
                <div class="role-badge">Admin</div>

                <div class="dash-line"></div>

                <div class="info-row">
                    <div class="info-icon green">
                        <svg viewBox="0 0 64 64">
                            <circle cx="32" cy="22" r="12"></circle>
                            <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ auth()->user()->name ?? 'Admin Klinik' }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon blue">
                        <svg viewBox="0 0 64 64">
                            <rect x="8" y="16" width="48" height="34" rx="3"></rect>
                            <path d="M8 20l24 18 24-18"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ auth()->user()->email ?? 'admin@klinik.test' }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon yellow">
                        <svg viewBox="0 0 64 64">
                            <path d="M32 6l22 9v15c0 15-9 25-22 30C19 55 10 45 10 30V15z"></path>
                            <path d="M23 33l6 6 13-15"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="info-label">Role</div>
                        <div class="info-value">Admin</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon green">
                        <svg viewBox="0 0 64 64">
                            <circle cx="32" cy="32" r="22"></circle>
                            <path d="M22 33l7 7 15-17"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="info-label">Status</div>
                        <div class="info-value">Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT PROFIL -->
        <div class="panel">
            <div class="panel-head blue">
                <div class="head-icon">
                    <svg viewBox="0 0 64 64">
                        <path d="M12 48l4-15L42 7l15 15-26 26z"></path>
                        <path d="M37 12l15 15"></path>
                        <path d="M12 48l18-5"></path>
                    </svg>
                </div>
                Edit Profil
            </div>

            <div class="form-body">
                @if(session('success_profile'))
                    <div class="alert success">{{ session('success_profile') }}</div>
                @endif

                @if($errors->has('name') || $errors->has('email'))
                    <div class="alert error">Data profil belum valid.</div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', auth()->user()->name) }}"
                            required
                        >
                        @error('name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                        >
                        @error('email')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="Admin" disabled>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="input-wrap">
                            <select class="form-control select-control" disabled>
                                <option>Aktif</option>
                            </select>

                            <svg class="select-arrow" viewBox="0 0 64 64">
                                <path d="M18 24l14 16 14-16"></path>
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="save-btn blue">
                        <svg viewBox="0 0 64 64">
                            <path d="M12 10h34l8 8v36H12z"></path>
                            <path d="M20 10v16h24V10"></path>
                            <path d="M20 54V36h24v18"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- UBAH PASSWORD -->
        <div class="panel">
            <div class="panel-head red">
                <div class="head-icon">
                    <svg viewBox="0 0 64 64">
                        <rect x="14" y="28" width="36" height="27" rx="4"></rect>
                        <path d="M22 28V18a10 10 0 0 1 20 0v10"></path>
                        <path d="M32 39v7"></path>
                    </svg>
                </div>
                Ubah Password
            </div>

            <div class="form-body">
                @if(session('success_password'))
                    <div class="alert success">{{ session('success_password') }}</div>
                @endif

                @if($errors->has('current_password') || $errors->has('password'))
                    <div class="alert error">Password belum valid.</div>
                @endif

                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <div class="input-wrap">
                            <input
                                id="currentPassword"
                                type="password"
                                name="current_password"
                                class="form-control password-control"
                                required
                            >

                            <button class="eye-btn" type="button" onclick="togglePassword('currentPassword', 'eyeCurrentOpen', 'eyeCurrentClosed')">
                                <svg id="eyeCurrentOpen" viewBox="0 0 64 64">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                </svg>
                                <svg id="eyeCurrentClosed" viewBox="0 0 64 64" style="display:none;">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                    <path d="M12 56L56 8"></path>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="input-wrap">
                            <input
                                id="newPassword"
                                type="password"
                                name="password"
                                class="form-control password-control"
                                required
                            >

                            <button class="eye-btn" type="button" onclick="togglePassword('newPassword', 'eyeNewOpen', 'eyeNewClosed')">
                                <svg id="eyeNewOpen" viewBox="0 0 64 64">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                </svg>
                                <svg id="eyeNewClosed" viewBox="0 0 64 64" style="display:none;">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                    <path d="M12 56L56 8"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-wrap">
                            <input
                                id="confirmPassword"
                                type="password"
                                name="password_confirmation"
                                class="form-control password-control"
                                required
                            >

                            <button class="eye-btn" type="button" onclick="togglePassword('confirmPassword', 'eyeConfirmOpen', 'eyeConfirmClosed')">
                                <svg id="eyeConfirmOpen" viewBox="0 0 64 64">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                </svg>
                                <svg id="eyeConfirmClosed" viewBox="0 0 64 64" style="display:none;">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                    <path d="M12 56L56 8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="save-btn red">
                        <svg viewBox="0 0 64 64">
                            <rect x="14" y="28" width="36" height="27" rx="4"></rect>
                            <path d="M22 28V18a10 10 0 0 1 20 0v10"></path>
                            <path d="M32 39v7"></path>
                        </svg>
                        Simpan Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('extra-js')
<script>
function togglePassword(inputId, openId, closedId) {
    const input = document.getElementById(inputId);
    const openIcon = document.getElementById(openId);
    const closedIcon = document.getElementById(closedId);

    if (input.type === 'password') {
        input.type = 'text';
        openIcon.style.display = 'none';
        closedIcon.style.display = 'block';
    } else {
        input.type = 'password';
        openIcon.style.display = 'block';
        closedIcon.style.display = 'none';
    }
}
</script>
@endsection
