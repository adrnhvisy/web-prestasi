<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Jurusan;
use App\Models\MasterData\Guru;
use App\Models\MasterData\TahunAjaran;
use App\Traits\Loggable; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    use Loggable; 

    /**
     * Tampilkan daftar kelas
     */
    public function index(Request $request)
    {
        $tahunAjaranList = TahunAjaran::all();
        $jurusanList = Jurusan::all();
        $tingkatList = ['X', 'XI', 'XII'];

        // Ambil data untuk dropdown filter di view
        $kelasList = Kelas::orderBy('tingkat')->orderBy('rombel')->get();

        $query = Kelas::with(['jurusan', 'tahunAjaran', 'waliKelas']);

        // --- Fitur Filter Ditambahkan Di Sini ---
        $query->when($request->tahun_ajaran, function ($q, $taId) {
            return $q->where('tahun_ajaran_id', $taId);
        })
        ->when($request->kelas, function ($q, $kelasId) {
            return $q->where('id', $kelasId);
        })
        ->when($request->tingkat, function ($q, $tingkat) {
            return $q->where('tingkat', $tingkat);
        })
        ->when($request->search, function ($q, $search) {
            return $q->where(function($subId) use ($search) {
                $subId->where('rombel', 'like', "%{$search}%")
                      ->orWhereHas('waliKelas', function($g) use ($search) {
                          $g->where('nama', 'like', "%{$search}%");
                      });
            });
        });

        $kelas = $query->orderBy('tingkat')
            ->orderBy('jurusan_id')
            ->orderBy('rombel')
            ->paginate(15)
            ->withQueryString();

        return view('master-data.kelas.index', compact(
            'kelas',
            'tahunAjaranList',
            'jurusanList',
            'tingkatList',
            'kelasList' // Ditambahkan agar tidak undefined di view
        ));
    }

    public function create()
    {
        $jurusanList = Jurusan::all();
        $guruList = Guru::all();
        $tahunAjaranList = TahunAjaran::all();
        $tingkatList = ['X', 'XI', 'XII'];

        return view('master-data.kelas.create', compact('jurusanList', 'guruList', 'tahunAjaranList', 'tingkatList'));
    }

    /**
     * Simpan data kelas baru dengan Log.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'required|integer|min:1|max:10',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'wali_kelas_id' => 'nullable|exists:guru,id',
        ]);

        $jurusan = Jurusan::findOrFail($request->jurusan_id);

        $exists = Kelas::where([
            ['tingkat', $request->tingkat],
            ['jurusan_id', $request->jurusan_id],
            ['rombel', $request->rombel],
            ['tahun_ajaran_id', $request->tahun_ajaran_id],
        ])->exists();

        if ($exists) {
            $namaKelas = "{$request->tingkat} {$jurusan->kode_jurusan} {$request->rombel}";
            return back()
                ->withInput()
                ->with('error', "Kelas {$namaKelas} sudah terdaftar pada tahun ajaran ini.");
        }

        try {
            DB::beginTransaction();

            $kelas = Kelas::create([
                'tingkat' => $request->tingkat,
                'jurusan_id' => $request->jurusan_id,
                'rombel' => $request->rombel,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'wali_kelas_id' => $request->wali_kelas_id,
            ]);

            $this->logActivity(
                "Menambahkan Kelas baru: {$kelas->nama_lengkap}",
                "kelas",
                $kelas->load(['jurusan', 'tahunAjaran'])->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.kelas.index')
                ->with('success', "Kelas {$kelas->nama_lengkap} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show(Kelas $kelas)
    {
        $kelas->load([
            'jurusan',
            'tahunAjaran',
            'waliKelas',
            'kelasSiswa' => function ($q) {
                $q->with('siswa')->whereNull('tanggal_keluar');
            }
        ]);

        return view('master-data.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $jurusanList = Jurusan::all();
        $guruList = Guru::all();
        $tahunAjaranList = TahunAjaran::all();
        $tingkatList = ['X', 'XI', 'XII'];

        return view('master-data.kelas.edit', compact('kelas', 'jurusanList', 'guruList', 'tahunAjaranList', 'tingkatList'));
    }

    /**
     * Update data kelas dengan Log perbandingan.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'required|integer|min:1|max:10',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'wali_kelas_id' => 'nullable|exists:guru,id',
        ]);

        $exists = Kelas::where('tingkat', $request->tingkat)
            ->where('jurusan_id', $request->jurusan_id)
            ->where('rombel', $request->rombel)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('id', '!=', $kelas->id)
            ->exists();

        if ($exists) {
            $jurusan = Jurusan::find($request->jurusan_id);
            $namaKelas = $request->tingkat . ' ' . $jurusan->kode_jurusan . ' ' . $request->rombel;
            return back()->withInput()->with('error', 'Kelas ' . $namaKelas . ' sudah ada di tahun ajaran ini.');
        }

        try {
            DB::beginTransaction();

            $oldData = $kelas->load(['jurusan', 'tahunAjaran'])->toArray();

            $kelas->update([
                'tingkat' => $request->tingkat,
                'jurusan_id' => $request->jurusan_id,
                'rombel' => $request->rombel,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'wali_kelas_id' => $request->wali_kelas_id,
            ]);

            $this->logActivity(
                "Memperbarui data Kelas: {$kelas->nama_lengkap}",
                "kelas",
                ['sebelum' => $oldData, 'sesudah' => $kelas->load(['jurusan', 'tahunAjaran'])->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.kelas.index')
                ->with('success', 'Kelas ' . $kelas->nama_lengkap . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Hapus kelas dengan Log.
     */
    public function destroy(Kelas $kelas)
    {
        if ($kelas->kelasSiswa()->whereNull('tanggal_keluar')->exists()) {
            return redirect()->route('master-data.kelas.index')
                ->with('error', 'Kelas masih memiliki siswa aktif.');
        }

        try {
            DB::beginTransaction();

            $namaKelas = $kelas->nama_lengkap;
            $dataHapus = $kelas->load(['jurusan', 'tahunAjaran'])->toArray();

            $kelas->delete();

            $this->logActivity(
                "Menghapus Kelas: {$namaKelas}",
                "kelas",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.kelas.index')
                ->with('success', 'Kelas ' . $namaKelas . ' berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.kelas.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}