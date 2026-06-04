@forelse($jadwals as $jadwal)
    <tr>
        <td>{{ $jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $jadwal->hari ?? '-' }}</td>
        <td>{{ $jadwal->jam_mulai ?? '-' }}</td>
        <td>{{ $jadwal->jam_selesai ?? '-' }}</td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="action-btn yellow">
                    <svg viewBox="0 0 64 64">
                        <path d="M12 48l4-15L42 7l15 15-26 26z"></path>
                        <path d="M37 12l15 15"></path>
                        <path d="M12 48l18-5"></path>
                    </svg>
                    Edit
                </a>

                <form
                    action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                    method="POST"
                    class="delete-jadwal-form"
                >
                    @csrf
                    @method('DELETE')

                    <button type="button" class="action-btn red delete-jadwal-btn">
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
        <td colspan="6" class="empty">
            Data jadwal dokter tidak ditemukan
        </td>
    </tr>
@endforelse
