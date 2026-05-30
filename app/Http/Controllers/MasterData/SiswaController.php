<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Kelas;
// use App\Models\MasterData\Jurusan;
use App\Models\MasterData\TahunAjaran;
use App\Models\User;
use App\Models\Operasional\KelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('kelas') && !empty($request->kelas)) {
            $query->whereHas('kelasSiswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas)->whereNull('tanggal_keluar');
            });
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(15);

        $kelasList = Kelas::where('tahun_ajaran_id', TahunAjaran::getActive()?->id)->get();

        return view('master-data.siswa.index', compact('siswa', 'kelasList'));
    }

    /**
     * Tampilkan form tambah siswa
     */
    public function create()
    {
        $kelasList = Kelas::where('tahun_ajaran_id', TahunAjaran::getActive()?->id)->get();
        return view('master-data.siswa.create', compact('kelasList'));
    }

    /**
     * Simpan data siswa baru
     */
    public function store(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $request->validate([
            'nis' => 'required|unique:siswa|max:50',
            'nisn' => 'nullable|unique:siswa|max:50',
            'nama_lengkap' => 'required|max:255',
            'tempat_lahir' => 'nullable|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|max:20',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:20',
            'nama_ayah' => 'nullable|max:255',
            'nama_ibu' => 'nullable|max:255',
            'pekerjaan_ortu' => 'nullable|max:100',
            'email' => 'nullable|email|unique:users,email',
            'username' => 'required|unique:users,username|max:100',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        // Buat user baru
        $user = User::create([
            'nama' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('siswa123'),
            'hak_akses' => 'siswa',
            'is_active' => true,
        ]);


        // Buat data siswa
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ortu' => $request->pekerjaan_ortu,
        ]);

        // Tempatkan di kelas jika dipilih
        if ($request->filled('kelas_id') && $tahunAjaranAktif) {
            KelasSiswa::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'tanggal_masuk' => now(),
            ]);
        }

        return redirect()->route('master-data.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan. Password default: siswa123');
    }

    /**
     * Tampilkan detail siswa
     */
    public function show(Siswa $siswa)
    {
        $tahunAjaranAktif = TahunAjaran::getActive();

        $siswa->load(['user', 'inputPelanggaran' => function ($q) {
            $q->with('pelanggaran')->latest()->limit(10);
        }, 'inputPrestasi' => function ($q) {
            $q->with('prestasi')->latest()->limit(10);
        }]);

        // PASTIKAN VARIABEL INI ADA, MESKIPUN NULL
        $kelasAktif = $siswa->getKelasAktif(); // Bisa null

        $rekap = $siswa->rekapPoin()
            ->where('tahun_ajaran_id', $tahunAjaranAktif?->id)
            ->first();

        // KIRIM SEMUA VARIABEL KE VIEW
        return view('master-data.siswa.show', compact('siswa', 'kelasAktif', 'rekap'));
    }

    /**
     * Tampilkan form edit siswa
     */
    public function edit(Siswa $siswa)
    {
        $kelasList = Kelas::where('tahun_ajaran_id', TahunAjaran::getActive()?->id)->get();
        $kelasSaatIni = $siswa->getKelasAktif();

        return view('master-data.siswa.edit', compact('siswa', 'kelasList', 'kelasSaatIni'));
    }

    /**
     * Update data siswa
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|max:50|unique:siswa,nis,' . $siswa->id,
            'nisn' => 'nullable|max:50|unique:siswa,nisn,' . $siswa->id,
            'nama_lengkap' => 'required|max:255',
            'tempat_lahir' => 'nullable|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|max:20',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:20',
            'nama_ayah' => 'nullable|max:255',
            'nama_ibu' => 'nullable|max:255',
            'pekerjaan_ortu' => 'nullable|max:100',
            'email' => 'nullable|email|unique:users,email,' . $siswa->user_id,
        ]);

        // Update user
        $siswa->user->update([
            'nama' => $request->nama_lengkap,
            'email' => $request->email,
        ]);

        // Update siswa
        $siswa->update($request->except(['email', 'username']));

        return redirect()->route('master-data.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus siswa
     */
    public function destroy(Siswa $siswa)
    {
        $userId = $siswa->user_id;
        $siswa->delete();
        User::where('id', $userId)->delete();

        return redirect()->route('master-data.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Reset password siswa
     */
    public function resetPassword(Siswa $siswa)
    {
        $siswa->user->update([
            'password' => Hash::make('siswa123')
        ]);

        return redirect()->route('master-data.siswa.show', $siswa->id)
            ->with('success', 'Password berhasil direset ke: siswa123');
    }
}