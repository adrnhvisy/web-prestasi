<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;
use App\Models\Operasional\KelasSiswa;
use Illuminate\Http\Request;

class KelasSiswaController extends Controller
{
    /**
     * Tampilkan daftar penempatan siswa
     */
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();
        $tahunAjaranId = $request->get('tahun_ajaran', $tahunAjaranAktif?->id);

        $query = KelasSiswa::with(['siswa', 'kelas', 'tahunAjaran']);

        // Filter berdasarkan tahun ajaran
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        // Filter berdasarkan kelas
        if ($request->has('kelas') && !empty($request->kelas)) {
            $query->where('kelas_id', $request->kelas);
        }

        // Filter berdasarkan status (aktif/alumni)
        if ($request->has('status') && $request->status == 'aktif') {
            $query->active();
        } elseif ($request->has('status') && $request->status == 'alumni') {
            $query->alumni();
        }

        // Pencarian berdasarkan nama siswa
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_lengkap', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('nis', 'LIKE', '%' . $request->search . '%');
            });
        }

        $kelasSiswa = $query->orderBy('tanggal_masuk', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Data untuk filter dropdown
        $tahunAjaranList = TahunAjaran::orderBy('nama', 'desc')->get();
        $kelasList = Kelas::with('jurusan')
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->orderBy('tingkat')
            ->orderBy('jurusan_id')
            ->orderBy('rombel')
            ->get();

        return view('operasional.kelas-siswa.index', compact('kelasSiswa', 'tahunAjaranList', 'kelasList', 'tahunAjaranId'));
    }

    /**
     * Tampilkan form tambah penempatan
     */
    public function create(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        if (!$tahunAjaranAktif) {
            return redirect()->route('operasional.kelas-siswa.index')
                ->with('error', 'Tidak ada tahun ajaran aktif. Silakan aktifkan tahun ajaran terlebih dahulu.');
        }

        // Ambil siswa yang belum memiliki kelas aktif, beserta kelas terakhir mereka
        $siswaTanpaKelas = Siswa::whereDoesntHave('kelasSiswa', function ($q) {
            $q->whereNull('tanggal_keluar');
        })
            ->with([
                'kelasSiswa' => function ($q) {
                    $q->with('kelas')->latest('tanggal_masuk')->limit(1);
                }
            ])
            ->orderBy('nama_lengkap')
            ->get();

        // Ambil semua kelas di tahun ajaran aktif
        $kelasList = Kelas::with('jurusan')
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->orderBy('tingkat')
            ->orderBy('jurusan_id')
            ->orderBy('rombel')
            ->get();

        $selectedSiswa = $request->get('siswa_id');

        return view('operasional.kelas-siswa.create', compact('siswaTanpaKelas', 'kelasList', 'tahunAjaranAktif', 'selectedSiswa'));
    }
    /**
     * Simpan data penempatan baru
     */
    public function store(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_masuk' => 'required|date',
        ]);

        // Cek apakah siswa sudah memiliki kelas aktif
        $siswa = Siswa::find($request->siswa_id);
        if ($siswa->getKelasAktif()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Siswa ' . $siswa->nama_lengkap . ' sudah memiliki kelas aktif.');
        }

        // Cek apakah sudah pernah ditempatkan di kelas yang sama di tahun ajaran yang sama
        $exists = KelasSiswa::where('siswa_id', $request->siswa_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Siswa sudah pernah terdaftar di kelas ini.');
        }

        KelasSiswa::create([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        $kelas = Kelas::find($request->kelas_id);
        $siswa = Siswa::find($request->siswa_id);

        return redirect()->route('operasional.kelas-siswa.index')
            ->with('success', 'Siswa ' . $siswa->nama_lengkap . ' berhasil ditempatkan di kelas ' . $kelas->nama_lengkap);
    }

    /**
     * Tampilkan detail penempatan
     */
    public function show(KelasSiswa $kelasSiswa)
    {
        $kelasSiswa->load(['siswa', 'kelas', 'tahunAjaran']);

        return view('operasional.kelas-siswa.show', compact('kelasSiswa'));
    }

    /**
     * Tampilkan form edit penempatan
     */
    public function edit(KelasSiswa $kelasSiswa)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        // Kelas yang tersedia di tahun ajaran yang sama
        $kelasList = Kelas::with('jurusan')
            ->where('tahun_ajaran_id', $kelasSiswa->tahun_ajaran_id)
            ->orderBy('tingkat')
            ->orderBy('jurusan_id')
            ->orderBy('rombel')
            ->get();

        return view('operasional.kelas-siswa.edit', compact('kelasSiswa', 'kelasList'));
    }

    /**
     * Update data penempatan
     */
    public function update(Request $request, KelasSiswa $kelasSiswa)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
        ]);

        // Cek duplikat (kecuali untuk data ini sendiri)
        $exists = KelasSiswa::where('siswa_id', $kelasSiswa->siswa_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $kelasSiswa->tahun_ajaran_id)
            ->where('id', '!=', $kelasSiswa->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Siswa sudah pernah terdaftar di kelas ini.');
        }

        $kelasSiswa->update([
            'kelas_id' => $request->kelas_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        return redirect()->route('operasional.kelas-siswa.index')
            ->with('success', 'Data penempatan berhasil diperbarui.');
    }

    /**
     * Hapus data penempatan
     */
    public function destroy(KelasSiswa $kelasSiswa)
    {
        $kelasSiswa->delete();

        return redirect()->route('operasional.kelas-siswa.index')
            ->with('success', 'Data penempatan berhasil dihapus.');
    }

    /**
     * Bulk assign - menempatkan banyak siswa sekaligus
     */
    public function bulkAssign(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $kelas = Kelas::find($request->kelas_id);
        $success = 0;
        $failed = 0;

        foreach ($request->siswa_ids as $siswaId) {
            $siswa = Siswa::find($siswaId);

            // Skip jika sudah punya kelas aktif
            if ($siswa->getKelasAktif()) {
                $failed++;
                continue;
            }

            // Cek apakah sudah pernah di kelas ini
            $exists = KelasSiswa::where('siswa_id', $siswaId)
                ->where('kelas_id', $request->kelas_id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->exists();

            if (!$exists) {
                KelasSiswa::create([
                    'siswa_id' => $siswaId,
                    'kelas_id' => $request->kelas_id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'tanggal_masuk' => $request->tanggal_masuk,
                ]);
                $success++;
            } else {
                $failed++;
            }
        }

        return redirect()->route('operasional.kelas-siswa.index')
            ->with('success', $success . ' siswa berhasil ditempatkan di kelas ' . $kelas->nama_lengkap . '. ' . $failed . ' siswa gagal (sudah memiliki kelas atau sudah terdaftar).');
    }

    /**
     * Graduate - menandai siswa keluar dari kelas (lulus/pindah)
     */
    public function graduate(KelasSiswa $kelasSiswa)
    {
        if ($kelasSiswa->tanggal_keluar) {
            return redirect()->route('operasional.kelas-siswa.index')
                ->with('error', 'Siswa sudah dikeluarkan dari kelas.');
        }

        $kelasSiswa->update([
            'tanggal_keluar' => now()
        ]);

        return redirect()->route('operasional.kelas-siswa.index')
            ->with('success', 'Siswa ' . $kelasSiswa->siswa->nama_lengkap . ' berhasil dikeluarkan dari kelas.');
    }
}