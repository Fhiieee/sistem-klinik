@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Edit Poli')
@section('page-subtitle', 'Perbarui data poli klinik')
@section('active-menu', 'poli')

@section('content')
<div class="edit-card">
    <div class="edit-title">Edit Poli</div>

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.poli.update', $poli->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group full">
                <label for="nama_poli">Nama Poli</label>
                <input
                    type="text"
                    id="nama_poli"
                    name="nama_poli"
                    class="form-control"
                    value="{{ old('nama_poli', $poli->nama_poli) }}"
                    placeholder="Contoh: Poli Umum"
                >
            </div>

            <div class="form-group full">
                <label for="deskripsi">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    class="form-control"
                    placeholder="Contoh: Melayani pemeriksaan kesehatan umum"
                >{{ old('deskripsi', $poli->deskripsi) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="neo-btn yellow">Simpan</button>
            <a href="{{ route('admin.poli.index') }}" class="neo-btn blue">Kembali</a>
        </div>
    </form>
</div>
@endsection
