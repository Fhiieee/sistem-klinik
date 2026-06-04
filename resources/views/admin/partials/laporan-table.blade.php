@forelse($pemeriksaans as $pemeriksaan)
    <tr>
        <td>{{ $pemeriksaan->pendaftaran->pasien->user->name ?? '-' }}</td>
        <td>{{ $pemeriksaan->pendaftaran->jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pemeriksaan->diagnosa ?? '-' }}</td>
        <td>{{ $pemeriksaan->resep ?? '-' }}</td>
        <td>
            {{ $pemeriksaan->created_at ? $pemeriksaan->created_at->format('d-m-Y') : '-' }}
        </td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.laporan.detail', $pemeriksaan->id) }}" class="action-btn blue">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="22"></circle>
                        <circle cx="32" cy="32" r="7"></circle>
                    </svg>
                    Detail
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="empty">
            Belum ada data laporan pemeriksaan
        </td>
    </tr>
@endforelse
