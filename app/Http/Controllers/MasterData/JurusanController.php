<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Jurusan;
use App\Traits\Loggable; // Import Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    use Loggable; // Gunakan Trait agar bisa memanggil $this->logActivity()

    public function index(Request $request)
    {
        $query = Jurusan::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_jurusan', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('nama_jurusan', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $jurusan = $query->orderBy('kode_jurusan')->paginate(10);

        return view('master-data.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('master-data.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:20|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $jurusan = Jurusan::create([
                'kode_jurusan' => strtoupper($request->kode_jurusan),
                'nama_jurusan' => $request->nama_jurusan,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Tambah Jurusan
            $this->logActivity(
                "Menambahkan Jurusan baru: {$jurusan->nama_jurusan}",
                "jurusan",
                $jurusan->toArray()
            );

            DB::commit();
            return redirect()->route('master-data.jurusan.index')
                ->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Jurusan $jurusan)
    {
        return view('master-data.jurusan.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan)
    {
        return view('master-data.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:20|unique:jurusan,kode_jurusan,' . $jurusan->id,
            'nama_jurusan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data lama untuk perbandingan di Log
            $oldData = $jurusan->toArray();

            $jurusan->update([
                'kode_jurusan' => strtoupper($request->kode_jurusan),
                'nama_jurusan' => $request->nama_jurusan,
                'deskripsi' => $request->deskripsi,
            ]);

            // CATAT LOG: Update Jurusan
            $this->logActivity(
                "Memperbarui data Jurusan: {$jurusan->nama_jurusan}",
                "jurusan",
                ['sebelum' => $oldData, 'sesudah' => $jurusan->toArray()]
            );

            DB::commit();
            return redirect()->route('master-data.jurusan.index')
                ->with('success', 'Jurusan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Jurusan $jurusan)
    {
        // Cek apakah jurusan masih digunakan di kelas
        if ($jurusan->kelas()->count() > 0) {
            return redirect()->route('master-data.jurusan.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena masih digunakan oleh data kelas.');
        }

        try {
            DB::beginTransaction();

            $namaJurusan = $jurusan->nama_jurusan;
            $dataHapus = $jurusan->toArray();

            $jurusan->delete();

            // CATAT LOG: Hapus Jurusan
            $this->logActivity(
                "Menghapus Jurusan: {$namaJurusan}",
                "jurusan",
                $dataHapus
            );

            DB::commit();
            return redirect()->route('master-data.jurusan.index')
                ->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master-data.jurusan.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }
}
