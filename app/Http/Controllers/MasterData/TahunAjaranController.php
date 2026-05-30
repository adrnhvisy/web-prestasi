<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\TahunAjaran;
use App\Traits\Loggable; // 1. Import Trait
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    use Loggable; // 2. Gunakan Trait

    /**
     * Tampilkan daftar tahun ajaran
     */
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderBy('created_at', 'desc')->paginate(10);
        return view('master-data.tahun-ajaran.index', compact('tahunAjaran'));
    }

    /**
     * Tampilkan form tambah tahun ajaran
     */
    public function create()
    {
        return view('master-data.tahun-ajaran.create');
    }

    /**
     * Simpan data tahun ajaran baru dengan Log
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tahun_ajaran')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                }),
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        ], [
            'nama.unique' => "Tahun ajaran {$request->nama} semester {$request->semester} sudah ada.",
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Jika di-set aktif, nonaktifkan periode lain
            if ($request->boolean('is_aktif')) {
                TahunAjaran::query()->update(['is_aktif' => false]);
                $data['is_aktif'] = true;
            }

            $tahunAjaran = TahunAjaran::create($data);

            // CATAT LOG: Tambah Tahun Ajaran
            $this->logActivity(
                "Menambah Tahun Ajaran: {$tahunAjaran->nama} ({$tahunAjaran->semester})",
                "tahun_ajaran",
                $tahunAjaran->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    /**
     * Tampilkan detail tahun ajaran
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        return view('master-data.tahun-ajaran.show', compact('tahunAjaran'));
    }

    /**
     * Tampilkan form edit tahun ajaran
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('master-data.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update data tahun ajaran dengan Log perbandingan
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tahun_ajaran')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                })->ignore($tahunAjaran->id),
            ],
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        ]);

        try {
            DB::beginTransaction();

            $oldData = $tahunAjaran->toArray();
            $data = $request->all();

            if ($request->boolean('is_aktif')) {
                TahunAjaran::where('id', '!=', $tahunAjaran->id)->update(['is_aktif' => false]);
                $data['is_aktif'] = true;
            }

            $tahunAjaran->update($data);

            // CATAT LOG: Update Tahun Ajaran
            $this->logActivity(
                "Memperbarui Tahun Ajaran: {$tahunAjaran->nama}",
                "tahun_ajaran",
                ['sebelum' => $oldData, 'sesudah' => $tahunAjaran->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Hapus tahun ajaran
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->is_aktif) {
            return back()->with('error', 'Tahun ajaran aktif tidak dapat dihapus.');
        }

        if ($tahunAjaran->kelas()->exists()) {
            return back()->with('error', 'Tahun ajaran masih memiliki data kelas.');
        }

        try {
            DB::beginTransaction();

            $info = "{$tahunAjaran->nama} ({$tahunAjaran->semester})";
            $dataHapus = $tahunAjaran->toArray();

            $tahunAjaran->delete();

            $this->logActivity("Menghapus Tahun Ajaran: $info", "tahun_ajaran", $dataHapus);

            DB::commit();
            return redirect()->route('master-data.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Aktifkan tahun ajaran secara manual dengan Log
     */
    public function activate(TahunAjaran $tahunAjaran)
    {
        try {
            DB::beginTransaction();

            TahunAjaran::setActive($tahunAjaran->id);

            $this->logActivity(
                "Mengaktifkan Tahun Ajaran: {$tahunAjaran->nama}",
                "tahun_ajaran",
                ['id' => $tahunAjaran->id, 'nama' => $tahunAjaran->nama]
            );

            DB::commit();
            return redirect()->route('master-data.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran ' . $tahunAjaran->nama . ' berhasil diaktifkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengaktifkan periode.');
        }
    }
}
