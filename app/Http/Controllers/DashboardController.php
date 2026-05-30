<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Import Model Anda
use App\Models\User;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Guru;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Pelanggaran;
use App\Models\MasterData\Prestasi;

// Sesuaikan nama model operasional Anda (contoh: Pelanggaran, Prestasi)

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('check.user.active'),
        ];
    }

    public function index()
    {
        $role = Auth::user()->hak_akses;

        // Logic Redirect berdasarkan Role
        if (in_array($role, ['superadmin', 'admin'])) {
            return $this->adminDashboard();
        } elseif ($role === 'bk') {
            return $this->bkDashboard();
        }

        // Default jika role lain (misal siswa)
        return view('dashboard.user', ['user' => Auth::user()]);
    }

    /**
     * Admin Dashboard - Data Dinamis dari Database
     */
    public function adminDashboard()
    {
        $data = [
            'user' => Auth::user(),
            'pageTitle' => 'Dashboard Admin',
            'statistik' => [
                'total_siswa' => Siswa::count(),
                'total_guru'  => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_pelanggaran' => Pelanggaran::count(),
                'total_prestasi'    => Prestasi::count(),
            ],
            'menuAktif' => 'dashboard',
        ];

        return view('dashboard.admin', $data);
    }

    /**
     * BK Dashboard - Data Dinamis (Bisa difilter jika perlu)
     */
    public function bkDashboard()
    {
        $data = [
            'user' => Auth::user(),
            'pageTitle' => 'Dashboard BK',
            'statistik' => [
                // Jika BK hanya melihat data tertentu, tambahkan where()
                'total_siswa' => Siswa::count(),
                'total_guru'  => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_pelanggaran' => Pelanggaran::count(),
                'total_prestasi'    => Prestasi::count(),
            ],
            'menuAktif' => 'dashboard',
        ];

        return view('dashboard.bk', $data);
    }
}
