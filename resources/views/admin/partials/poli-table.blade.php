@forelse($polis as $poli)
    <tr>
        <td>{{ $poli->nama_poli ?? '-' }}</td>
        <td>{{ $poli->deskripsi ?? '-' }}</td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.poli.edit', $poli->id) }}" class="action-btn yellow">
                    Edit
                </a>

                <form action="{{ route('admin.poli.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data poli ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="action-btn red">
                        Hapus
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="empty">
            Data poli tidak ditemukan
        </td>
    </tr>
@endforelse
