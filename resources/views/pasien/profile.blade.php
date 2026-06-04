@extends('layouts.app')

@section('layout-type', 'pasien')
@section('active-menu', 'profile')

@section('page-title', 'Profil Pasien')
@section('page-subtitle', 'Kelola informasi akun dan data pasien Anda')

@section('content')
<div class="pasien-profile-content">

    @if(session('success'))
        <div class="pasien-profile-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pasien-profile-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pasien-profile-alert error">
            Data belum valid. Periksa kembali form profil Anda.
        </div>
    @endif

    <div class="pasien-profile-grid">

        <div class="pasien-profile-card pasien-profile-info">
            <div class="pasien-profile-card-head green">
                <div class="pasien-profile-head-icon">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="22" r="12"></circle>
                        <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                    </svg>
                </div>
                Informasi Akun
            </div>

            <div class="pasien-profile-info-body">
                <div class="pasien-profile-avatar">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="22" r="12"></circle>
                        <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                    </svg>
                </div>

                <div class="pasien-profile-name">
                    {{ auth()->user()->name ?? 'Pasien Klinik' }}
                </div>

                <div class="pasien-profile-role">
                    Pasien
                </div>

                <div class="pasien-profile-line"></div>

                <div class="pasien-profile-row">
                    <div class="pasien-profile-row-icon blue">
                        <svg viewBox="0 0 64 64">
                            <circle cx="32" cy="22" r="12"></circle>
                            <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="pasien-profile-label">Nama</div>
                        <div class="pasien-profile-value">{{ auth()->user()->name ?? '-' }}</div>
                    </div>
                </div>

                <div class="pasien-profile-row">
                    <div class="pasien-profile-row-icon yellow">
                        <svg viewBox="0 0 64 64">
                            <rect x="10" y="16" width="44" height="34" rx="3"></rect>
                            <path d="M10 20l22 17 22-17"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="pasien-profile-label">Email</div>
                        <div class="pasien-profile-value">{{ auth()->user()->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="pasien-profile-row">
                    <div class="pasien-profile-row-icon green">
                        <svg viewBox="0 0 64 64">
                            <rect x="14" y="12" width="36" height="44" rx="3"></rect>
                            <path d="M22 25h20M22 35h20M22 45h12"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="pasien-profile-label">NIK</div>
                        <div class="pasien-profile-value">{{ $pasien->nik ?? '-' }}</div>
                    </div>
                </div>

                <div class="pasien-profile-row">
                    <div class="pasien-profile-row-icon red">
                        <svg viewBox="0 0 64 64">
                            <path d="M20 10h24v44H20z"></path>
                            <path d="M27 15h10M29 49h6"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="pasien-profile-label">No. HP</div>
                        <div class="pasien-profile-value">{{ $pasien->no_hp ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pasien-profile-card">
            <div class="pasien-profile-card-head blue">
                <div class="pasien-profile-head-icon">
                    <svg viewBox="0 0 64 64">
                        <path d="M14 50h36"></path>
                        <path d="M18 46l26-26 8 8-26 26H18z"></path>
                    </svg>
                </div>
                Edit Profil Pasien
            </div>

            <form action="{{ route('pasien.profile.update') }}" method="POST" class="pasien-profile-form">
                @csrf
                @method('PUT')

                <div class="pasien-profile-form-grid">
                    <div class="pasien-profile-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}">
                        @error('name')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                        @error('email')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $pasien->nik ?? '') }}">
                        @error('nik')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ?? '') }}">
                        @error('tanggal_lahir')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp ?? '') }}">
                        @error('no_hp')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-profile-form-group full">
                        <label>Alamat</label>
                        <textarea name="alamat">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="pasien-profile-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="pasien-profile-save-btn">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
