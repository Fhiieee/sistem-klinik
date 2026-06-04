@forelse($pendaftarans as $pendaftaran)
    <tr>
        <td>{{ $pendaftaran->pasien->user->name ?? '-' }}</td>
        <td>{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pendaftaran->jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $pendaftaran->tanggal_daftar ?? '-' }}</td>
        <td>{{ $pendaftaran->nomor_antrian ?? $pendaftaran->nomor_antrean ?? '-' }}</td>
        <td>
            <span class="status {{ $pendaftaran->status ?? 'menunggu' }}">
                {{ ucfirst($pendaftaran->status ?? 'menunggu') }}
            </span>
        </td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.pendaftaran.edit', $pendaftaran->id) }}" class="action-btn yellow">
                    <svg viewBox="0 0 64 64">
                        <path d="M12 48l4-15L42 7l15 15-26 26z"></path>
                        <path d="M37 12l15 15"></path>
                        <path d="M12 48l18-5"></path>
                    </svg>
                    Edit
                </a>

                <form
                    action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id) }}"
                    method="POST"
                    class="delete-pendaftaran-form"
                >
                    @csrf
                    @method('DELETE')

                    <button type="button" class="action-btn red delete-pendaftaran-btn">
                        <svg viewBox="0 0 64 64">
                            <path d="M16 18h32"></path>
                            <path d="M24 18V10h16v8"></path>
                            <path d="M22 24l2 30h16l2-30"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="empty">
            Belum ada data pendaftaran
        </td>
    </tr>
@endforelse
