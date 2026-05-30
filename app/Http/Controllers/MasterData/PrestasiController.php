<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Prestasi;
use App\Models\MasterData\KategoriPrestasi;
use App\Traits\Loggable; // 1. Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestasiController extends Controller
{
    use Loggable; // 2. Gunakan Trait

    public function index(Request $request)
    {
        $query = Prestasi::with('kategori');

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_prestasi', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('kategori_id') && !empty($request->kategori_id)) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $prestasi = $query->latest()->paginate(10);
        $kategoriList = KategoriPrestasi::orderBy('nama_kategori')->get();

        return view('master-data.prestasi.index', compact('prestasi', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = KategoriPrestasi::orderBy('nama_kategori')->get();
        return view('master-data.prestasi.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_prestasi,id',
            'nama_prestasi' => 'required|string|max:255',
            'point' => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $prestasi = Prestasi::create([
                'kategori_id' => $request->kategori_id,
                'nama_prestasi' => $request->nama_prestasi,
                'point' => $request->point,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Tambah Prestasi
            $this->logActivity(
                "Menambahkan Jenis Prestasi: {$prestasi->nama_prestasi}",
                "prestasi",
                $prestasi->load('kategori')->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.prestasi.index')
                ->with('success', 'Jenis prestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->loadCount('inputPrestasi');
        return view('master-data.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $kategoriList = KategoriPrestasi::orderBy('nama_kategori')->get();
        return view('master-data.prestasi.edit', compact('prestasi', 'kategoriList'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_prestasi,id',
            'nama_prestasi' => 'required|string|max:255',
            'point' => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data lama untuk perbandingan log
            $oldData = $prestasi->load('kategori')->toArray();

            $prestasi->update([
                'kategori_id' => $request->kategori_id,
                'nama_prestasi' => $request->nama_prestasi,
                'point' => $request->point,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Update Prestasi
            $this->logActivity(
                "Memperbarui Jenis Prestasi: {$prestasi->nama_prestasi}",
                "prestasi",
                ['sebelum' => $oldData, 'sesudah' => $prestasi->load('kategori')->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.prestasi.index')
                ->with('success', 'Jenis prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->inputPrestasi()->count() > 0) {
            return redirect()->route('master-data.prestasi.index')
                ->with('error', 'Prestasi tidak dapat dihapus karena sudah tercatat pada data siswa.');
        }

        try {
            DB::beginTransaction();

            $namaPrestasi = $prestasi->nama_prestasi;
            $dataHapus = $prestasi->load('kategori')->toArray();

            $prestasi->delete();

            // CATAT LOG: Hapus Prestasi
            $this->logActivity(
                "Menghapus Jenis Prestasi: {$namaPrestasi}",
                "prestasi",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.prestasi.index')
                ->with('success', 'Jenis prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.prestasi.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}
