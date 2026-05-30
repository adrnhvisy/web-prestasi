<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\KategoriPelanggaran;
use App\Models\MasterData\Pelanggaran;
use App\Traits\Loggable; // 1. Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelanggaranController extends Controller
{
    use Loggable; // 2. Gunakan Trait

    /**
     * Tampilkan daftar pelanggaran
     */
    public function index(Request $request)
    {
        $query = Pelanggaran::with('kategori');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_pelanggaran', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('kategori_id', $request->kategori);
        }

        $pelanggaran = $query->orderBy('nama_pelanggaran')->paginate(15);
        $kategoriList = KategoriPelanggaran::all();

        return view('master-data.pelanggaran.index', compact('pelanggaran', 'kategoriList'));
    }

    /**
     * Tampilkan form tambah pelanggaran
     */
    public function create()
    {
        $kategoriList = KategoriPelanggaran::all();
        return view('master-data.pelanggaran.create', compact('kategoriList'));
    }

    /**
     * Simpan data pelanggaran baru dengan Log
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pelanggaran,id',
            'nama_pelanggaran' => 'required|max:255',
            'point' => 'required|integer|min:0',
            'deskripsi' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $pelanggaran = Pelanggaran::create($request->all());

            // CATAT LOG: Tambah Pelanggaran
            $this->logActivity(
                "Menambahkan Jenis Pelanggaran: {$pelanggaran->nama_pelanggaran}",
                "pelanggaran",
                $pelanggaran->load('kategori')->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.pelanggaran.index')
                ->with('success', 'Jenis pelanggaran berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail pelanggaran
     */
    public function show(Pelanggaran $pelanggaran)
    {
        return view('master-data.pelanggaran.show', compact('pelanggaran'));
    }

    /**
     * Tampilkan form edit pelanggaran
     */
    public function edit(Pelanggaran $pelanggaran)
    {
        $kategoriList = KategoriPelanggaran::all();
        return view('master-data.pelanggaran.edit', compact('pelanggaran', 'kategoriList'));
    }

    /**
     * Update data pelanggaran dengan Log perbandingan
     */
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pelanggaran,id',
            'nama_pelanggaran' => 'required|max:255',
            'point' => 'required|integer|min:0',
            'deskripsi' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data lama untuk perbandingan log
            $oldData = $pelanggaran->load('kategori')->toArray();

            $pelanggaran->update($request->all());

            // CATAT LOG: Update Pelanggaran
            $this->logActivity(
                "Memperbarui Jenis Pelanggaran: {$pelanggaran->nama_pelanggaran}",
                "pelanggaran",
                ['sebelum' => $oldData, 'sesudah' => $pelanggaran->load('kategori')->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.pelanggaran.index')
                ->with('success', 'Jenis pelanggaran berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Hapus pelanggaran dengan Log
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        if ($pelanggaran->inputPelanggaran()->exists()) {
            return redirect()->route('master-data.pelanggaran.index')
                ->with('error', 'Pelanggaran tidak bisa dihapus karena sudah pernah digunakan dalam pencatatan.');
        }

        try {
            DB::beginTransaction();

            $namaPelanggaran = $pelanggaran->nama_pelanggaran;
            $dataHapus = $pelanggaran->load('kategori')->toArray();

            $pelanggaran->delete();

            // CATAT LOG: Hapus Pelanggaran
            $this->logActivity(
                "Menghapus Jenis Pelanggaran: {$namaPelanggaran}",
                "pelanggaran",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.pelanggaran.index')
                ->with('success', 'Jenis pelanggaran berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.pelanggaran.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}