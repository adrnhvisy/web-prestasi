<?php

// namespace App\Http\Controllers\MasterData;

// use App\Http\Controllers\Controller;
// use App\Models\MasterData\Guru;
// use App\Models\User;
// use App\Traits\Loggable;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;

// class GuruController extends Controller
// {
//     use Loggable; // Mengaktifkan fungsi logActivity()

//     public function index(Request $request)
//     {
//         $query = Guru::with('user');

//         if ($request->has('search') && !empty($request->search)) {
//             $query->where(function ($q) use ($request) {
//                 $q->where('nama_lengkap', 'LIKE', '%' . $request->search . '%')
//                     ->orWhere('nip', 'LIKE', '%' . $request->search . '%')
//                     ->orWhere('nuptk', 'LIKE', '%' . $request->search . '%');
//             });
//         }

//         $guru = $query->latest()->paginate(10);

//         return view('master-data.guru.index', compact('guru'));
//     }

//     public function create()
//     {
//         return view('master-data.guru.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'nama_lengkap' => 'required|string|max:150',
//             'email' => 'required|email|unique:users,email',
//             'username' => 'required|string|unique:users,username',
//             'nip' => 'required|string|unique:guru,nip',
//             'jenis_kelamin' => 'required|in:L,P',
//             'password' => 'nullable|string|min:8|confirmed',
//         ]);

//         try {
//             DB::beginTransaction();

//             $password = $request->filled('password') ? $request->password : 'guru123';

//             $user = User::create([
//                 'nama' => $request->nama_lengkap,
//                 'username' => $request->username,
//                 'email' => $request->email,
//                 'password' => Hash::make($password),
//                 'role' => 'guru',
//             ]);

//             $user->guru()->create([
//                 'nip' => $request->nip,
//                 'nuptk' => $request->nuptk,
//                 'nama_lengkap' => $request->nama_lengkap,
//                 'tempat_lahir' => $request->tempat_lahir,
//                 'tanggal_lahir' => $request->tanggal_lahir,
//                 'jenis_kelamin' => $request->jenis_kelamin,
//                 'agama' => $request->agama,
//                 'alamat' => $request->alamat,
//                 'no_telp' => $request->no_telp,
//                 'pendidikan_terakhir' => $request->pendidikan_terakhir,
//                 'jabatan' => $request->jabatan,
//                 'email' => $request->email,
//             ]);

//             // CATAT LOG: Tambah Guru
//             $this->logActivity(
//                 "Menambahkan Guru baru: {$request->nama_lengkap}",
//                 "guru",
//                 ['nip' => $request->nip, 'email' => $request->email]
//             );

//             DB::commit();
//             return redirect()->route('master-data.guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
//         }
//     }

//     public function show(Guru $guru)
//     {
//         return view('master-data.guru.show', compact('guru'));
//     }

//     public function edit(Guru $guru)
//     {
//         return view('master-data.guru.edit', compact('guru'));
//     }

//     public function update(Request $request, Guru $guru)
//     {
//         $request->validate([
//             'nama_lengkap' => 'required|string|max:150',
//             'email' => 'required|email|unique:users,email,' . $guru->user_id,
//             'nip' => 'required|string|unique:guru,nip,' . $guru->id,
//             'jenis_kelamin' => 'required|in:L,P',
//             'password' => 'nullable|min:6',
//         ]);

//         try {
//             DB::beginTransaction();

//             // Simpan data lama untuk Log sebelum diupdate
//             $oldData = $guru->load('user')->toArray();

//             $userData = [
//                 'nama' => $request->nama_lengkap,
//                 'email' => $request->email,
//             ];

//             if ($request->filled('password')) {
//                 $userData['password'] = Hash::make($request->password);
//             }

//             $guru->user->update($userData);
//             $guru->update($request->all());

//             // CATAT LOG: Update Guru
//             $this->logActivity(
//                 "Memperbarui data Guru: {$guru->nama_lengkap}",
//                 "guru",
//                 ['sebelum' => $oldData, 'sesudah' => $request->all()]
//             );

//             DB::commit();
//             return redirect()->route('master-data.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
//         }
//     }

//     public function destroy(Guru $guru)
//     {
//         if ($guru->waliKelas()->exists()) {
//             return back()->with('error', 'Guru tidak bisa dihapus karena masih menjabat sebagai Wali Kelas.');
//         }

//         try {
//             DB::beginTransaction();

//             $namaGuru = $guru->nama_lengkap;
//             $nipGuru = $guru->nip;
//             $userId = $guru->user_id;

//             $guru->delete();
//             User::find($userId)->delete();

//             // CATAT LOG: Hapus Guru
//             $this->logActivity(
//                 "Menghapus Guru: {$namaGuru}",
//                 "guru",
//                 ['nip' => $nipGuru]
//             );

//             DB::commit();
//             return redirect()->route('master-data.guru.index')->with('success', 'Data Guru dan Akun berhasil dihapus.');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->with('error', 'Gagal menghapus data.');
//         }
//     }
// }


namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Guru;
use App\Models\User;
use App\Models\ManagementAccess\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Tampilkan daftar guru
     */
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $guru = $query->orderBy('nama_lengkap')->paginate(15);

        return view('master-data.guru.index', compact('guru'));
    }

    /**
     * Tampilkan form tambah guru
     */
    public function create()
    {
        return view('master-data.guru.create');
    }

    /**
     * Simpan data guru baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru|max:50',
            'nuptk' => 'nullable|unique:guru|max:50',
            'nama_lengkap' => 'required|max:255',
            'tempat_lahir' => 'nullable|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|max:20',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:20',
            'pendidikan_terakhir' => 'nullable|max:100',
            'jabatan' => 'nullable|max:100',
            'email' => 'nullable|email|unique:users,email',
            'username' => 'required|unique:users,username|max:100',
        ]);

        // Buat user baru
        $user = User::create([
            'nama' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('guru123'),
            'is_active' => true,
        ]);

        // 2. Berikan role 'guru' menggunakan Spatie Role method
        $user->assignRole('guru');

        // Buat data guru
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nuptk' => $request->nuptk,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('master-data.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan. Password default: guru123');
    }

    /**
     * Tampilkan detail guru
     */
    public function show(Guru $guru)
    {
        $guru->load(['user', 'waliKelas']);
        return view('master-data.guru.show', compact('guru'));
    }

    /**
     * Tampilkan form edit guru
     */
    public function edit(Guru $guru)
    {
        return view('master-data.guru.edit', compact('guru'));
    }

    /**
     * Update data guru
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|max:50|unique:guru,nip,' . $guru->id,
            'nuptk' => 'nullable|max:50|unique:guru,nuptk,' . $guru->id,
            'nama_lengkap' => 'required|max:255',
            'tempat_lahir' => 'nullable|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|max:20',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:20',
            'pendidikan_terakhir' => 'nullable|max:100',
            'jabatan' => 'nullable|max:100',
            'email' => 'nullable|email|unique:users,email,' . $guru->user_id,
        ]);

        // Update user
        $guru->user->update([
            'nama' => $request->nama_lengkap,
            'email' => $request->email,
        ]);

        // Update guru
        $guru->update($request->except(['email', 'username']));

        return redirect()->route('master-data.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Hapus guru
     */
    public function destroy(Guru $guru)
    {
        if ($guru->waliKelas()->exists()) {
            return redirect()->route('master-data.guru.index')
                ->with('error', 'Guru masih menjadi wali kelas.');
        }

        $userId = $guru->user_id;
        $guru->delete();
        User::where('id', $userId)->delete();

        return redirect()->route('master-data.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Reset password guru
     */
    public function resetPassword(Guru $guru)
    {
        $guru->user->update([
            'password' => Hash::make('guru123')
        ]);

        return redirect()->route('master-data.guru.show', $guru->id)
            ->with('success', 'Password berhasil direset ke: guru123');
    }
}