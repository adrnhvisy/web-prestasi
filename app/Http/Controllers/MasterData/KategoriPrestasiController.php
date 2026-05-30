<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\KategoriPrestasi;
use App\Traits\Loggable; // 1. Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriPrestasiController extends Controller
{
    use Loggable; // 2. Gunakan Trait

    /**
     * Menampilkan daftar kategori dengan fitur pencarian dan jumlah relasi.
     */
    public function index(Request $request)
    {
        $query = KategoriPrestasi::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kategori', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $kategori = $query->withCount('prestasi')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('master-data.kategori-prestasi.index', compact('kategori'));
    }

    public function create()
    {
        return view('master-data.kategori-prestasi.create');
    }

    /**
     * Menyimpan data baru ke database dengan Log.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_prestasi,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $kategori = KategoriPrestasi::create([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Tambah Kategori
            $this->logActivity(
                "Menambahkan Kategori Prestasi: {$kategori->nama_kategori}",
                "kategori_prestasi",
                $kategori->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.kategori-prestasi.index')
                ->with('success', 'Kategori prestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(KategoriPrestasi $kategoriPrestasi)
    {
        $kategoriPrestasi->load('prestasi');
        return view('master-data.kategori-prestasi.show', compact('kategoriPrestasi'));
    }

    public function edit(KategoriPrestasi $kategoriPrestasi)
    {
        return view('master-data.kategori-prestasi.edit', compact('kategoriPrestasi'));
    }

    /**
     * Memperbarui data di database dengan Log perbandingan data.
     */
    public function update(Request $request, KategoriPrestasi $kategoriPrestasi)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_prestasi,nama_kategori,' . $kategoriPrestasi->id,
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data lama untuk audit
            $oldData = $kategoriPrestasi->toArray();

            $kategoriPrestasi->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Update Kategori
            $this->logActivity(
                "Memperbarui Kategori Prestasi: {$kategoriPrestasi->nama_kategori}",
                "kategori_prestasi",
                ['sebelum' => $oldData, 'sesudah' => $kategoriPrestasi->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.kategori-prestasi.index')
                ->with('success', 'Kategori prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data dengan pengecekan relasi dan Log.
     */
    public function destroy(KategoriPrestasi $kategoriPrestasi)
    {
        if ($kategoriPrestasi->prestasi()->count() > 0) {
            return redirect()->route('master-data.kategori-prestasi.index')
                ->with('error', 'Gagal menghapus! Kategori ini masih memiliki data prestasi di dalamnya.');
        }

        try {
            DB::beginTransaction();

            $namaKategori = $kategoriPrestasi->nama_kategori;
            $dataHapus = $kategoriPrestasi->toArray();

            $kategoriPrestasi->delete();

            // CATAT LOG: Hapus Kategori
            $this->logActivity(
                "Menghapus Kategori Prestasi: {$namaKategori}",
                "kategori_prestasi",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.kategori-prestasi.index')
                ->with('success', 'Kategori prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.kategori-prestasi.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}
