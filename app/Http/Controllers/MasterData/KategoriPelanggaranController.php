<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\KategoriPelanggaran;
use App\Traits\Loggable; // Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriPelanggaranController extends Controller
{
    use Loggable; // Gunakan Trait

    /**
     * Tampilkan daftar kategori pelanggaran
     */
    public function index()
    {
        $kategori = KategoriPelanggaran::withCount('pelanggaran')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('master-data.kategori-pelanggaran.index', compact('kategori'));
    }

    /**
     * Tampilkan form tambah kategori
     */
    public function create()
    {
        return view('master-data.kategori-pelanggaran.create');
    }

    /**
     * Simpan data kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_pelanggaran|max:100',
            'deskripsi' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $kategori = KategoriPelanggaran::create($request->all());

            // CATAT LOG: Tambah Kategori
            $this->logActivity(
                "Menambahkan Kategori Pelanggaran: {$kategori->nama_kategori}",
                "kategori_pelanggaran",
                $kategori->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.kategori-pelanggaran.index')
                ->with('success', 'Kategori pelanggaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail kategori
     */
    public function show(KategoriPelanggaran $kategoriPelanggaran)
    {
        return view('master-data.kategori-pelanggaran.show', compact('kategoriPelanggaran'));
    }

    /**
     * Tampilkan form edit kategori
     */
    public function edit(KategoriPelanggaran $kategoriPelanggaran)
    {
        return view('master-data.kategori-pelanggaran.edit', compact('kategoriPelanggaran'));
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, KategoriPelanggaran $kategoriPelanggaran)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategori_pelanggaran,nama_kategori,' . $kategoriPelanggaran->id,
            'deskripsi' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data lama untuk perbandingan
            $oldData = $kategoriPelanggaran->toArray();

            $kategoriPelanggaran->update($request->all());

            // CATAT LOG: Update Kategori
            $this->logActivity(
                "Memperbarui Kategori Pelanggaran: {$kategoriPelanggaran->nama_kategori}",
                "kategori_pelanggaran",
                ['sebelum' => $oldData, 'sesudah' => $kategoriPelanggaran->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.kategori-pelanggaran.index')
                ->with('success', 'Kategori pelanggaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kategori
     */
    public function destroy(KategoriPelanggaran $kategoriPelanggaran)
    {
        if ($kategoriPelanggaran->pelanggaran()->exists()) {
            return redirect()->route('master-data.kategori-pelanggaran.index')
                ->with('error', 'Kategori masih memiliki data pelanggaran.');
        }

        try {
            DB::beginTransaction();

            $namaKategori = $kategoriPelanggaran->nama_kategori;
            $dataHapus = $kategoriPelanggaran->toArray();

            $kategoriPelanggaran->delete();

            // CATAT LOG: Hapus Kategori
            $this->logActivity(
                "Menghapus Kategori Pelanggaran: {$namaKategori}",
                "kategori_pelanggaran",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.kategori-pelanggaran.index')
                ->with('success', 'Kategori pelanggaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.kategori-pelanggaran.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}
