@forelse($pemeriksaans as $pemeriksaan)
    <tr>
        <td>{{ $pemeriksaan->pendaftaran->jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pemeriksaan->keluhan ?? '-' }}</td>
        <td>{{ $pemeriksaan->diagnosa ?? '-' }}</td>
        <td>{{ $pemeriksaan->resep ?? '-' }}</td>
        <td>
            {{ $pemeriksaan->created_at ? $pemeriksaan->created_at->format('d-m-Y') : '-' }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="pasien-riwayat-empty">
            Belum ada data riwayat pemeriksaan
        </td>
    </tr>
@endforelse
