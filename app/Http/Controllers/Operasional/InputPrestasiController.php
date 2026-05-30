<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Prestasi;
use App\Models\Operasional\InputPrestasi;
use App\Traits\Loggable; // 1. Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InputPrestasiController extends Controller
{
    use Loggable; // 2. Gunakan Trait

    public function index(Request $request)
    {
        $filterKelas = Kelas::all();
        $query = InputPrestasi::with(['siswa', 'prestasi', 'kelas', 'guru']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                    ->orWhere('nis', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $prestasi = $query->latest()->paginate(10)->withQueryString();

        return view('operasional.input-prestasi.index', compact('prestasi', 'filterKelas'));
    }

    public function create()
    {
        $dataSiswa = Siswa::orderBy('nama_lengkap', 'asc')->get();
        $dataPrestasi = Prestasi::orderBy('point', 'desc')->get();

        return view('operasional.input-prestasi.create', compact('dataSiswa', 'dataPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'prestasi_id' => 'required|exists:prestasi,id',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $siswa = Siswa::with('user')->findOrFail($request->siswa_id);

            // Validasi User Aktif
            if (!$siswa->user || !$siswa->user->is_active) {
                return back()->with('error', 'Akun siswa tersebut sudah tidak aktif.');
            }

            // Ambil Kelas Aktif dari history (kelas_siswa)
            $kelasAktif = $siswa->kelasSiswa()
                ->whereNull('tanggal_keluar')
                ->latest()
                ->first();

            if (!$kelasAktif) {
                return back()->with('error', 'Siswa belum terdaftar di kelas aktif manapun.');
            }

            // Generate Kode (ACH = Achievement)
            $date = now()->format('Ymd');
            $count = InputPrestasi::whereDate('created_at', now())->count() + 1;
            $kode = 'ACH-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $input = InputPrestasi::create([
                'kode_transaksi' => $kode,
                'siswa_id' => $request->siswa_id,
                'prestasi_id' => $request->prestasi_id,
                'kelas_id' => $kelasAktif->kelas_id,
                'user_id' => Auth::id(),
                'tahun_ajaran_id' => $kelasAktif->tahun_ajaran_id,
                'waktu' => now(),
                'keterangan' => $request->keterangan,
            ]);

            // CATAT LOG: Input Prestasi Baru
            $this->logActivity(
                "Mencatat Prestasi: {$kode} - {$siswa->nama_lengkap}",
                "operasional",
                $input->load(['siswa', 'prestasi', 'kelas'])->toArray()
            );

            DB::commit();
            return redirect()->route('operasional.input-prestasi.index')
                ->with('success', 'Data prestasi berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mencatat data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = InputPrestasi::with(['siswa', 'prestasi', 'kelas', 'guru', 'tahunAjaran'])->findOrFail($id);
        return view('operasional.input-prestasi.show', compact('data'));
    }

    public function edit($id)
    {
        $inputPrestasi = InputPrestasi::with(['siswa', 'prestasi'])->findOrFail($id);
        $dataPrestasi = Prestasi::orderBy('point', 'desc')->get();

        return view('operasional.input-prestasi.edit', compact('inputPrestasi', 'dataPrestasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prestasi_id' => 'required|exists:prestasi,id',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $inputPrestasi = InputPrestasi::findOrFail($id);
            $siswa = Siswa::with('user')->findOrFail($inputPrestasi->siswa_id);

            if (!$siswa->user || !$siswa->user->is_active) {
                return back()->with('error', 'Gagal memperbarui: Akun siswa tersebut sudah tidak aktif.');
            }

            $oldData = $inputPrestasi->load(['siswa', 'prestasi'])->toArray();

            $inputPrestasi->update([
                'prestasi_id' => $request->prestasi_id,
                'keterangan'  => $request->keterangan,
            ]);

            // CATAT LOG: Perubahan Data Prestasi
            $this->logActivity(
                "Memperbarui Data Prestasi: {$inputPrestasi->kode_transaksi}",
                "operasional",
                ['sebelum' => $oldData, 'sesudah' => $inputPrestasi->load('prestasi')->toArray()]
            );

            DB::commit();
            return redirect()->route('operasional.input-prestasi.index')
                ->with('success', 'Data prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data = InputPrestasi::findOrFail($id);
            $kode = $data->kode_transaksi;
            $dataHapus = $data->load(['siswa', 'prestasi'])->toArray();

            $data->delete();

            // CATAT LOG: Penghapusan Prestasi
            $this->logActivity(
                "Menghapus Data Prestasi: {$kode}",
                "operasional",
                $dataHapus
            );

            DB::commit();
            return back()->with('success', 'Data prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
