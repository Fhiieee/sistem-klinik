@forelse($pemeriksaans ?? [] as $pemeriksaan)
    <tr>
        <td>{{ $pemeriksaan->pendaftaran->pasien->user->name ?? '-' }}</td>
        <td>{{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pemeriksaan->keluhan ?? '-' }}</td>
        <td>{{ $pemeriksaan->diagnosa ?? '-' }}</td>
        <td>{{ $pemeriksaan->resep ?? '-' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="dokter-empty">
            Belum ada riwayat pemeriksaan
        </td>
    </tr>
@endforelse
