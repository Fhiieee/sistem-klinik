@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Edit Dokter')
@section('page-subtitle', 'Perbarui data dokter')
@section('active-menu', 'dokter')

@section('content')
<div class="edit-card">
    <div class="edit-title">Edit Dokter</div>

    @if(session('error'))
        <div class="error-box">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Nama Dokter</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $dokter->user->name) }}"
                >
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $dokter->user->email) }}"
                >
            </div>

            <div class="form-group">
                <label>Spesialis</label>
                <input
                    type="text"
                    name="spesialis"
                    class="form-control"
                    value="{{ old('spesialis', $dokter->spesialis) }}"
                >
            </div>

            <div class="form-group">
                <label>No. SIP</label>
                <input
                    type="text"
                    name="no_sip"
                    class="form-control"
                    value="{{ old('no_sip', $dokter->no_sip) }}"
                >
            </div>

            <div class="form-group">
                <label>No. HP</label>
                <input
                    type="text"
                    name="no_hp"
                    class="form-control"
                    value="{{ old('no_hp', $dokter->no_hp) }}"
                >
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ old('status', $dokter->status) == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="nonaktif" {{ old('status', $dokter->status) == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                >
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div class="form-group full">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $dokter->alamat) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="neo-btn yellow">Simpan</button>
            <a href="{{ route('admin.dokter.index') }}" class="neo-btn blue">Kembali</a>
        </div>
    </form>
</div>
@endsection
