<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Pelanggaran;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;
use App\Models\Operasional\InputPelanggaran;
use App\Models\Operasional\RekapPoinSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InputPelanggaranController extends Controller
{
    /**
     * Tampilkan daftar input pelanggaran
     */
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $query = InputPelanggaran::with(['siswa', 'pelanggaran', 'kelas', 'user']);

        // Filter berdasarkan tahun ajaran
        if ($tahunAjaranAktif) {
            $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas);
        }

        // Filter berdasarkan siswa
        if ($request->filled('siswa')) {
            $query->where('siswa_id', $request->siswa);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('waktu', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('waktu', '<=', $request->end_date);
        }

        $inputs = $query->latest()->paginate(20);

        // Data untuk filter dropdown
        $kelasList = Kelas::where('tahun_ajaran_id', $tahunAjaranAktif?->id)->get();
        $siswaList = Siswa::orderBy('nama_lengkap')->get();

        return view('operasional.input-pelanggaran.index', compact('inputs', 'kelasList', 'siswaList'));
    }

    /**
     * Tampilkan form tambah input pelanggaran
     */
    public function create()
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        if (!$tahunAjaranAktif) {
            return redirect()->route('operasional.input-pelanggaran.index')
                ->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        // Ambil semua siswa (dengan kelas aktifnya)
        $siswa = Siswa::with([
            'kelasSiswa' => function ($q) use ($tahunAjaranAktif) {
                $q->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->whereNull('tanggal_keluar')
                    ->with('kelas');
            }
        ])->orderBy('nama_lengkap')->get();

        // Ambil semua pelanggaran
        $pelanggaran = Pelanggaran::with('kategori')->orderBy('nama_pelanggaran')->get();

        return view('operasional.input-pelanggaran.create', compact('siswa', 'pelanggaran'));
    }

    /**
     * Simpan data input pelanggaran baru - DENGAN KODE MANUAL
     */
    public function store(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'waktu' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Gunakan database transaction untuk keamanan
        DB::beginTransaction();

        try {
            $siswa = Siswa::find($request->siswa_id);

            // Dapatkan kelas aktif siswa
            $kelasSiswa = $siswa->kelasSiswa()
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->whereNull('tanggal_keluar')
                ->first();

            if (!$kelasSiswa) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Siswa tidak memiliki kelas aktif di tahun ajaran ini.');
            }

            // User yang menginput (user yang login)
            $user = Auth::user();

            // GENERATE KODE TRANSAKSI MANUAL
            $kodeTransaksi = $this->generateKodeTransaksi();

            // Simpan data
            $input = InputPelanggaran::create([
                'kode_transaksi' => $kodeTransaksi, // MANUAL
                'siswa_id' => $request->siswa_id,
                'pelanggaran_id' => $request->pelanggaran_id,
                'kelas_id' => $kelasSiswa->kelas_id,
                'user_id' => $user?->id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'waktu' => $request->waktu,
                'keterangan' => $request->keterangan,
            ]);

            // Update rekap poin
            $input->updateRekapPoin();

            DB::commit();

            return redirect()->route('operasional.input-pelanggaran.index')
                ->with('success', 'Data pelanggaran berhasil disimpan. Kode transaksi: ' . $input->kode_transaksi);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate kode transaksi manual
     */
    private function generateKodeTransaksi()
    {
        $prefix = 'PLG';
        $date = now()->format('Ymd');

        // Cari transaksi terakhir hari ini
        $last = InputPelanggaran::whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            // Ambil 4 digit terakhir, tambah 1
            $lastNumber = intval(substr($last->kode_transaksi, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Transaksi pertama hari ini
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }

    /**
     * Tampilkan detail input pelanggaran
     */
    public function show(InputPelanggaran $inputPelanggaran)
    {
        $inputPelanggaran->load(['siswa', 'pelanggaran', 'kelas', 'user', 'tahunAjaran']);

        return view('operasional.input-pelanggaran.show', compact('inputPelanggaran'));
    }

    /**
     * Tampilkan form edit input pelanggaran
     */
    public function edit(InputPelanggaran $inputPelanggaran)
    {
        $pelanggaran = Pelanggaran::with('kategori')->orderBy('nama_pelanggaran')->get();

        return view('operasional.input-pelanggaran.edit', compact('inputPelanggaran', 'pelanggaran'));
    }

    /**
     * Update data input pelanggaran
     */
    public function update(Request $request, InputPelanggaran $inputPelanggaran)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'waktu' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $inputPelanggaran->update([
                'pelanggaran_id' => $request->pelanggaran_id,
                'waktu' => $request->waktu,
                'keterangan' => $request->keterangan,
            ]);

            // Update rekap poin setelah perubahan
            $inputPelanggaran->updateRekapPoin();

            DB::commit();

            return redirect()->route('operasional.input-pelanggaran.index')
                ->with('success', 'Data pelanggaran ' . $inputPelanggaran->kode_transaksi . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus input pelanggaran
     */
    public function destroy(InputPelanggaran $inputPelanggaran)
    {
        DB::beginTransaction();

        try {
            $kode = $inputPelanggaran->kode_transaksi;
            $siswaId = $inputPelanggaran->siswa_id;
            $tahunAjaranId = $inputPelanggaran->tahun_ajaran_id;

            $inputPelanggaran->delete();

            // Update rekap poin setelah hapus
            $rekap = RekapPoinSiswa::where('siswa_id', $siswaId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->first();

            if ($rekap) {
                $rekap->updateRekap();
            }

            DB::commit();

            return redirect()->route('operasional.input-pelanggaran.index')
                ->with('success', 'Data pelanggaran ' . $kode . ' berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}