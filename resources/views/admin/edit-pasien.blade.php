@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Edit Pasien')
@section('page-subtitle', 'Perbarui data pasien')
@section('active-menu', 'pasien')

@section('content')
<div class="edit-card">
    <div class="edit-title">Edit Pasien</div>

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $pasien->user->name) }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $pasien->user->email) }}">
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" class="form-control" value="{{ old('nik', $pasien->nik) }}">
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $pasien->no_hp) }}">
            </div>

            <div class="form-group full">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $pasien->alamat) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="neo-btn yellow">Simpan</button>
            <a href="{{ route('admin.pasien.index') }}" class="neo-btn blue">Kembali</a>
        </div>
    </form>
</div>
@endsection
