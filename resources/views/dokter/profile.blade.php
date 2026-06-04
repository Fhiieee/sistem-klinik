@extends('layouts.app')

@section('layout-type', 'dokter')
@section('active-menu', 'profile')

@section('page-title', 'Profil Dokter')
@section('page-subtitle', 'Kelola informasi akun dan data dokter')

@section('content')
<div class="dokter-profile-content">

    @if(session('success'))
        <div class="dokter-profile-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="dokter-profile-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="dokter-profile-alert error">
            Data belum valid. Periksa kembali form profil dokter.
        </div>
    @endif

    <div class="dokter-profile-grid">

        <div class="dokter-profile-card dokter-profile-info">
            <div class="dokter-profile-card-head blue">
                <div class="dokter-profile-head-icon">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="17" r="10"></circle>
                        <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                        <path d="M24 36l8 10 8-10"></path>
                    </svg>
                </div>
                Informasi Dokter
            </div>

            <div class="dokter-profile-info-body">
                <div class="dokter-profile-avatar">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="17" r="10"></circle>
                        <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                        <path d="M24 36l8 10 8-10"></path>
                    </svg>
                </div>

                <div class="dokter-profile-name">
                    {{ auth()->user()->name ?? 'Dokter Klinik' }}
                </div>

                <div class="dokter-profile-role">
                    Dokter
                </div>

                <div class="dokter-profile-line"></div>

                <div class="dokter-profile-row">
                    <div class="dokter-profile-row-icon blue">
                        <svg viewBox="0 0 64 64">
                            <circle cx="32" cy="22" r="12"></circle>
                            <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="dokter-profile-label">Nama</div>
                        <div class="dokter-profile-value">{{ auth()->user()->name ?? '-' }}</div>
                    </div>
                </div>

                <div class="dokter-profile-row">
                    <div class="dokter-profile-row-icon yellow">
                        <svg viewBox="0 0 64 64">
                            <rect x="10" y="16" width="44" height="34" rx="3"></rect>
                            <path d="M10 20l22 17 22-17"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="dokter-profile-label">Email</div>
                        <div class="dokter-profile-value">{{ auth()->user()->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="dokter-profile-row">
                    <div class="dokter-profile-row-icon green">
                        <svg viewBox="0 0 64 64">
                            <rect x="14" y="12" width="36" height="44" rx="3"></rect>
                            <path d="M22 25h20M22 35h20M22 45h12"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="dokter-profile-label">Spesialis</div>
                        <div class="dokter-profile-value">{{ $dokter->spesialis ?? '-' }}</div>
                    </div>
                </div>

                <div class="dokter-profile-row">
                    <div class="dokter-profile-row-icon red">
                        <svg viewBox="0 0 64 64">
                            <path d="M20 10h24v44H20z"></path>
                            <path d="M27 15h10M29 49h6"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="dokter-profile-label">No. HP</div>
                        <div class="dokter-profile-value">{{ $dokter->no_hp ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dokter-profile-card">
            <div class="dokter-profile-card-head green">
                <div class="dokter-profile-head-icon">
                    <svg viewBox="0 0 64 64">
                        <path d="M14 50h36"></path>
                        <path d="M18 46l26-26 8 8-26 26H18z"></path>
                    </svg>
                </div>
                Edit Profil Dokter
            </div>

            <form action="{{ route('dokter.profile.update') }}" method="POST" class="dokter-profile-form">
                @csrf
                @method('PUT')

                <div class="dokter-profile-form-grid">
                    <div class="dokter-profile-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}">
                        @error('name')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                        @error('email')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group">
                        <label>Spesialis</label>
                        <input type="text" name="spesialis" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">
                        @error('spesialis')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group">
                        <label>No. SIP</label>
                        <input type="text" name="no_sip" value="{{ old('no_sip', $dokter->no_sip ?? '') }}">
                        @error('no_sip')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $dokter->no_hp ?? '') }}">
                        @error('no_hp')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="aktif" {{ old('status', $dokter->status ?? '') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif" {{ old('status', $dokter->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                        @error('status')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="dokter-profile-form-group full">
                        <label>Alamat</label>
                        <textarea name="alamat">{{ old('alamat', $dokter->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="dokter-profile-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="dokter-profile-save-btn">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
