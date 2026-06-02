<?php

namespace App\Http\Controllers\ManagementAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Operasional\LogAktivitas;
// Import interface untuk Laravel 11/12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Pengganti __construct untuk Laravel terbaru menggunakan Spatie Role.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('role:superadmin|admin', only: [
                'index',
                'create',
                'store',
                'destroy',
                'toggleActive'
            ]),

            new Middleware(function ($request, $next) {
                $targetUser = $request->route('user');

                if (
                    $targetUser instanceof User
                    && !auth()->user()->hasAnyRole(['superadmin', 'admin'])
                    && auth()->id() !== $targetUser->id
                ) {
                    abort(403);
                }

                return $next($request);
            }, only: [
                'show',
                'edit',
                'update'
            ]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan hasAnyRole dari Spatie
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403);
        }

        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', "%{$request->search}%")
                    ->orWhere('username', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            });
        }

        // Filter role menggunakan relasi Spatie
        if ($request->filled('hak_akses')) {
            $query->role($request->hak_akses);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $hakAksesList = [
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'guru' => 'Guru',
            'bk' => 'Guru BK',
            'siswa' => 'Siswa',
            'ortu' => 'Orang Tua'
        ];

        return view('management-access.users.index', compact('users', 'hakAksesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambah user.');
        }

        $hakAksesList = [
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'guru' => 'Guru',
            'bk' => 'Guru BK',
            'siswa' => 'Siswa',
            'ortu' => 'Orang Tua'
        ];

        return view('management-access.users.create', compact('hakAksesList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambah user.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'hak_akses' => 'required|in:superadmin,admin,guru,bk,siswa,ortu',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hak_akses === 'superadmin' && !Auth::user()->hasRole('superadmin')) {
            return back()->withErrors(['hak_akses' => 'Hanya Super Admin yang dapat membuat user Super Admin.'])->withInput();
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Berikan role menggunakan Spatie
        $user->assignRole($request->hak_akses);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menambah user: ' . $user->username,
            'modul' => 'USER_MANAGEMENT',
            'data' => json_encode($user->load('roles')->toArray()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Logic Redirect
        if (in_array($request->hak_akses, ['guru', 'bk'])) {
            return redirect()->route('management-access.guru.create', ['user_id' => $user->id])
                ->with('success', 'User berhasil ditambahkan. Silakan lengkapi data guru.');
        } elseif ($request->hak_akses === 'siswa') {
            return redirect()->route('management-access.siswa.create', ['user_id' => $user->id])
                ->with('success', 'User berhasil ditambahkan. Silakan lengkapi data siswa.');
        }

        return redirect()->route('management-access.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin']) && Auth::id() !== $user->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $user->load(['guru', 'siswa.kelasSiswa.kelas', 'roles']);

        return view('management-access.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin']) && Auth::id() !== $user->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $hakAksesList = [
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'guru' => 'Guru',
            'bk' => 'Guru BK',
            'siswa' => 'Siswa',
            'ortu' => 'Orang Tua'
        ];

        return view('management-access.users.edit', compact('user', 'hakAksesList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin']) && Auth::id() !== $user->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ];

        if (Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            $rules['hak_akses'] = 'required|in:superadmin,admin,guru,bk,siswa,ortu';
            $rules['is_active'] = 'nullable|boolean';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        // Security Check: Superadmin
        if ($request->filled('hak_akses') && $request->hak_akses === 'superadmin' && !Auth::user()->hasRole('superadmin')) {
            return back()->withErrors(['hak_akses' => 'Hanya Super Admin yang bisa memberi akses ini.']);
        }

        // Hindari penghapusan superadmin terakhir
        if ($user->hasRole('superadmin') && $request->filled('hak_akses') && $request->hak_akses !== 'superadmin') {
            if (User::role('superadmin')->count() <= 1) {
                return back()->withErrors(['hak_akses' => 'Tidak dapat mengubah Super Admin terakhir.']);
            }
        }

        $data = $request->only(['nama', 'email', 'no_telp', 'alamat']);

        if (Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            $data['is_active'] = $request->boolean('is_active', $user->is_active);
            
            // Sync role baru via Spatie jika ada perubahan
            if ($request->filled('hak_akses')) {
                $user->syncRoles([$request->hak_akses]);
            }
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengupdate user: ' . $user->username,
            'modul' => 'USER_MANAGEMENT',
            'data' => json_encode($request->except(['password', 'password_confirmation'])),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Auth::user()->hasAnyRole(['superadmin', 'admin'])
            ? redirect()->route('management-access.users.index')->with('success', 'User diperbarui.')
            : redirect()->route('management-access.users.show', $user->id)->with('success', 'Profil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->hasRole('superadmin') && User::role('superadmin')->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus Super Admin terakhir.');
        }

        $username = $user->username;
        $user->delete();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus user: ' . $username,
            'modul' => 'USER_MANAGEMENT',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('management-access.users.index')->with('success', 'User dihapus.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleActive(Request $request, User $user)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa mengubah status sendiri.'], 400);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Status diubah.'
        ]);
    }
}