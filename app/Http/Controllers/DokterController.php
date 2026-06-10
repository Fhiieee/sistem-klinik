<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    private function checkDokter()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses khusus dokter!');
        }

        return null;
    }

    private function getDokterLogin()
    {
        return Dokter::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function dashboard()
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();

        $totalJadwal = Jadwal::where('dokter_id', $dokter->id)->count();

        $totalPasienHariIni = Pendaftaran::whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->whereDate('tanggal_daftar', now()->toDateString())
            ->count();

        $totalPemeriksaan = Pemeriksaan::whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->count();

        $pendaftaranTerbaru = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
                'pemeriksaan',
            ])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dokter.dashboard', compact(
            'dokter',
            'totalJadwal',
            'totalPasienHariIni',
            'totalPemeriksaan',
            'pendaftaranTerbaru'
        ));
    }

    public function jadwal(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();
        $search = $request->search;

        $jadwals = Jadwal::with([
                'dokter.user',
                'poli',
            ])
            ->where('dokter_id', $dokter->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('hari', 'like', '%' . $search . '%')
                        ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                        ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                        ->orWhereHas('poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $totalJadwal = Jadwal::where('dokter_id', $dokter->id)->count();

        return view('dokter.jadwal', compact(
            'dokter',
            'jadwals',
            'totalJadwal',
            'search'
        ));
    }

    public function searchJadwalAjax(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $dokter = $this->getDokterLogin();

        $search = $request->search;

        $jadwals = Jadwal::with(['dokter.user', 'poli'])
            ->where('dokter_id', $dokter->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('hari', 'like', '%' . $search . '%')
                        ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                        ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                        ->orWhereHas('poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $html = view('dokter.partials.jadwal-table', compact('jadwals'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function pemeriksaan(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();
        $search = $request->search;

        $pendaftarans = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
                'pemeriksaan',
            ])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('status', 'like', '%' . $search . '%')
                        ->orWhereDate('tanggal_daftar', $search)
                        ->orWhereHas('pasien.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('jadwal.poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $totalPendaftaran = Pendaftaran::whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->count();

        $totalMenunggu = Pendaftaran::whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->where('status', 'menunggu')
            ->count();

        $totalSelesai = Pendaftaran::whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->where('status', 'selesai')
            ->count();

        return view('dokter.pemeriksaan', compact(
            'dokter',
            'pendaftarans',
            'totalPendaftaran',
            'totalMenunggu',
            'totalSelesai',
            'search'
        ));
    }

    public function searchPemeriksaanAjax(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $dokter = $this->getDokterLogin();
        $search = $request->search;

        $pendaftarans = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
                'pemeriksaan',
            ])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('status', 'like', '%' . $search . '%')
                        ->orWhere('tanggal_daftar', 'like', '%' . $search . '%')
                        ->orWhere('nomor_antrean', 'like', '%' . $search . '%')
                        ->orWhereHas('pasien.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('jadwal.poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $html = view('dokter.partials.pemeriksaan-table', compact('pendaftarans'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function createPemeriksaan($pendaftaranId)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();

        $pendaftaran = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
                'pemeriksaan',
            ])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->findOrFail($pendaftaranId);

        if ($pendaftaran->pemeriksaan) {
            return redirect()
                ->route('dokter.pemeriksaan.detail', $pendaftaran->pemeriksaan->id)
                ->with('error', 'Data pemeriksaan pasien ini sudah pernah dibuat.');
        }

        return view('dokter.tambah-pemeriksaan', compact(
            'dokter',
            'pendaftaran'
        ));
    }

    public function storePemeriksaan(Request $request, $pendaftaranId)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();

        $pendaftaran = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
                'pemeriksaan',
            ])
            ->whereHas('jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->findOrFail($pendaftaranId);

        if ($pendaftaran->pemeriksaan) {
            return redirect()
                ->route('dokter.pemeriksaan.detail', $pendaftaran->pemeriksaan->id)
                ->with('error', 'Data pemeriksaan pasien ini sudah pernah dibuat.');
        }

        $request->validate([
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'resep' => 'nullable|string',
        ], [
            'keluhan.required' => 'Keluhan pasien wajib diisi.',
            'diagnosa.required' => 'Diagnosa wajib diisi.',
        ]);

        DB::beginTransaction();

        try {
            $pemeriksaan = Pemeriksaan::create([
                'pendaftaran_id' => $pendaftaran->id,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'resep' => $request->resep,
            ]);

            $pendaftaran->update([
                'status' => 'selesai',
            ]);

            DB::commit();

            return redirect()
                ->route('dokter.pemeriksaan.detail', $pemeriksaan->id)
                ->with('success', 'Data pemeriksaan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Data pemeriksaan gagal disimpan.');
        }
    }

    public function detailPemeriksaan($pemeriksaanId)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();

        $pemeriksaan = Pemeriksaan::with([
                'pendaftaran.pasien.user',
                'pendaftaran.jadwal.dokter.user',
                'pendaftaran.jadwal.poli',
            ])
            ->whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->findOrFail($pemeriksaanId);

        return view('dokter.detail-pemeriksaan', compact(
            'dokter',
            'pemeriksaan'
        ));
    }

    public function laporan(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return $redirect;
        }

        $dokter = $this->getDokterLogin();
        $search = $request->search;

        $pemeriksaans = Pemeriksaan::with([
                'pendaftaran.pasien.user',
                'pendaftaran.jadwal.dokter.user',
                'pendaftaran.jadwal.poli',
            ])
            ->whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('keluhan', 'like', '%' . $search . '%')
                        ->orWhere('diagnosa', 'like', '%' . $search . '%')
                        ->orWhere('resep', 'like', '%' . $search . '%')
                        ->orWhereHas('pendaftaran.pasien.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('pendaftaran.jadwal.poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $totalPemeriksaan = Pemeriksaan::whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->count();

        $pemeriksaanHariIni = Pemeriksaan::whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->whereDate('created_at', now()->toDateString())
            ->count();

        return view('dokter.laporan', compact(
            'dokter',
            'pemeriksaans',
            'totalPemeriksaan',
            'pemeriksaanHariIni',
            'search'
        ));
    }

    public function searchLaporanAjax(Request $request)
    {
        if ($redirect = $this->checkDokter()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $dokter = $this->getDokterLogin();
        $search = $request->search;

        $pemeriksaans = Pemeriksaan::with([
                'pendaftaran.pasien.user',
                'pendaftaran.jadwal.dokter.user',
                'pendaftaran.jadwal.poli',
            ])
            ->whereHas('pendaftaran.jadwal', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('keluhan', 'like', '%' . $search . '%')
                        ->orWhere('diagnosa', 'like', '%' . $search . '%')
                        ->orWhere('resep', 'like', '%' . $search . '%')
                        ->orWhereHas('pendaftaran.pasien.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('pendaftaran.jadwal.poli', function ($poliQuery) use ($search) {
                            $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        $html = view('dokter.partials.laporan-table', compact('pemeriksaans'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses khusus dokter!');
        }

        $dokter = Dokter::with('user')
            ->where('user_id', Auth::id())
            ->first();

        if (!$dokter) {
            return redirect()->route('login')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('dokter.profile', compact('dokter'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses khusus dokter!');
        }

        $dokter = Dokter::where('user_id', Auth::id())->first();

        if (!$dokter) {
            return redirect()->route('login')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'spesialis' => 'required|string|max:255',
            'no_sip' => 'required|string|max:100|unique:dokters,no_sip,' . $dokter->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'name.required' => 'Nama dokter wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'spesialis.required' => 'Spesialis wajib diisi.',
            'no_sip.required' => 'No. SIP wajib diisi.',
            'no_sip.unique' => 'No. SIP sudah digunakan.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $dokter->update([
            'spesialis' => $request->spesialis,
            'no_sip' => $request->no_sip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Profil dokter berhasil diperbarui!');
    }
}
