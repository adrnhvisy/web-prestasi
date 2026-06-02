<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

// Master Data Controllers
use App\Http\Controllers\MasterData\JurusanController;
use App\Http\Controllers\MasterData\KelasController;
use App\Http\Controllers\MasterData\TahunAjaranController;
use App\Http\Controllers\MasterData\KategoriPelanggaranController;
use App\Http\Controllers\MasterData\PelanggaranController;
use App\Http\Controllers\MasterData\KategoriPrestasiController;
use App\Http\Controllers\MasterData\PrestasiController;
use App\Http\Controllers\MasterData\GuruController;
use App\Http\Controllers\MasterData\SiswaController;

// Management Access Controllers
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\ManagementAccess\ProfileController;

// Operasional Controllers
use App\Http\Controllers\Operasional\KelasSiswaController;
use App\Http\Controllers\Operasional\InputPelanggaranController;
use App\Http\Controllers\Operasional\InputPrestasiController;
use App\Http\Controllers\Operasional\LogAktivitasController;

// Report Controllers
use App\Http\Controllers\Report\LaporanSiswaController;
use App\Http\Controllers\Report\LaporanKelasController;
use App\Http\Controllers\Report\RankingController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// =============================================
// 1. PUBLIC ROUTES (TIDAK PERLU LOGIN)
// =============================================

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// AUTH ROUTES
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// =============================================
// 2. PROTECTED ROUTES (HARUS LOGIN DAN AKTIF)
// =============================================

Route::middleware(['auth', 'check.user.active'])->group(function () {
    
    // Dashboard (auto redirect berdasarkan hak akses)
    Route::middleware(['role', 'superadmin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    Route::middleware(['permission:user.view'])->group(function () {
        Route::get('/users', [UserController::class,'index']);
    });
    // Dashboard khusus berdasarkan role (untuk redirect manual)
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/dashboard/bk', [DashboardController::class, 'bkDashboard'])->name('bk.dashboard');
    Route::get('/dashboard/guru', [DashboardController::class, 'guruDashboard'])->name('guru.dashboard');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');
    Route::get('/dashboard/ortu', [DashboardController::class, 'ortuDashboard'])->name('ortu.dashboard');

    // =============================================
    // 3. PROFILE (SEMUA USER)
    // =============================================
     Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('pdate-foto', [ProfileController::class, 'updateFoto'])->name('update-foto');
    });

    // =============================================
    // 4. MASTER DATA (AKSES TERBATAS)
    // =============================================
    Route::prefix('master-data')->name('master-data.')->middleware(['check.master-data.access'])->group(function () {
        
        // Jurusan - Hanya superadmin & admin
        Route::resource('jurusan', JurusanController::class);
        
        // Kelas - Hanya superadmin & admin & wali kelas tertentu
        Route::resource('kelas', KelasController::class)->parameters([
            'kelas' => 'kelas'
        ]);
        
        // Tahun Ajaran - Hanya superadmin & admin
        Route::resource('tahun-ajaran', TahunAjaranController::class);
        Route::post('tahun-ajaran/{tahun_ajaran}/activate', [TahunAjaranController::class, 'activate'])
            ->name('tahun-ajaran.activate');

        // Kategori & Poin - Hanya superadmin, admin, BK
        Route::resource('kategori-pelanggaran', KategoriPelanggaranController::class);
        Route::resource('pelanggaran', PelanggaranController::class);
        Route::resource('kategori-prestasi', KategoriPrestasiController::class);
        Route::resource('prestasi', PrestasiController::class);

        // Data Guru - Hanya superadmin & admin
        Route::resource('guru', GuruController::class);
        Route::post('guru/{guru}/reset-password', [GuruController::class, 'resetPassword'])
            ->name('guru.reset-password');

        // Data Siswa - Hanya superadmin, admin, BK
        Route::resource('siswa', SiswaController::class);
        Route::post('siswa/{siswa}/reset-password', [SiswaController::class, 'resetPassword'])
            ->name('siswa.reset-password');
        Route::get('siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export-excel');
        Route::get('siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.export-pdf');
    });

    // =============================================
    // 5. MANAGEMENT ACCESS (HANYA SUPERADMIN & ADMIN)
    // =============================================
    Route::prefix('management-access')->name('management-access.')->middleware(['check.admin.access'])->group(function () {
        // Manajemen User
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
    });

    // =============================================
    // 6. OPERASIONAL (INPUT DATA)
    // =============================================
    Route::prefix('operasional')->name('operasional.')->group(function () {
        
        // Kelas Siswa (Penempatan siswa di kelas) - Hanya admin & BK
        Route::middleware(['check.admin.bk.access'])->group(function () {
            Route::resource('kelas-siswa', KelasSiswaController::class);
            Route::post('kelas-siswa/bulk-assign', [KelasSiswaController::class, 'bulkAssign'])->name('kelas-siswa.bulk-assign');
            Route::post('kelas-siswa/{kelas_siswa}/graduate', [KelasSiswaController::class, 'graduate'])->name('kelas-siswa.graduate');
            Route::get('kelas-siswa/export/{kelas}', [KelasSiswaController::class, 'export'])->name('kelas-siswa.export');
        });

        // Input Pelanggaran - Guru, BK, Admin
        Route::middleware(['check.input.pelanggaran'])->group(function () {
            Route::resource('input-pelanggaran', InputPelanggaranController::class);
            Route::get('input-pelanggaran/export/excel', [InputPelanggaranController::class, 'exportExcel'])
                ->name('input-pelanggaran.export-excel');
            Route::get('input-pelanggaran/export/pdf', [InputPelanggaranController::class, 'exportPdf'])
                ->name('input-pelanggaran.export-pdf');
        });

        // Input Prestasi - Guru, BK, Admin
        Route::middleware(['check.input.prestasi'])->group(function () {
            Route::resource('input-prestasi', InputPrestasiController::class);
            Route::get('input-prestasi/export/excel', [InputPrestasiController::class, 'exportExcel'])
                ->name('input-prestasi.export-excel');
            Route::get('input-prestasi/export/pdf', [InputPrestasiController::class, 'exportPdf'])
                ->name('input-prestasi.export-pdf');
        });

        // Log Aktivitas - Hanya superadmin & admin
        Route::middleware(['check.admin.access'])->group(function () {
            Route::resource('log-aktivitas', LogAktivitasController::class)->only(['index', 'show']);
            Route::delete('log-aktivitas/clear', [LogAktivitasController::class, 'clear'])
                ->name('log-aktivitas.clear');
            Route::get('log-aktivitas/export/excel', [LogAktivitasController::class, 'exportExcel'])
                ->name('log-aktivitas.export-excel');
        });
    });

    // =============================================
    // 7. REPORTS (LAPORAN)
    // =============================================
    Route::prefix('reports')->name('reports.')->group(function () {
        
        // Laporan Siswa
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('rekap', [LaporanSiswaController::class, 'rekapSiswa'])->name('rekap');
            Route::get('{siswa}/detail', [LaporanSiswaController::class, 'detailSiswa'])->name('detail');

        // Export routes
        Route::get('export/excel', [LaporanSiswaController::class, 'exportExcel'])->name('export-excel');
        Route::get('export/pdf', [LaporanSiswaController::class, 'exportRekapPdf'])->name('export-pdf');
        Route::get('{siswa}/export/pdf', [LaporanSiswaController::class, 'exportDetailPdf'])->name('siswa-detail-pdf');
        });

        // Laporan Kelas - Guru, BK, Admin
        Route::middleware(['check.kelas.report'])->group(function () {
            Route::prefix('kelas')->name('kelas.')->group(function () {
                Route::get('rekap', [LaporanKelasController::class, 'rekapKelas'])->name('rekap');
                Route::get('{kelas}/detail', [LaporanKelasController::class, 'detailKelas'])->name('detail');
                // Route::get('{kelas}/export/excel', [LaporanKelasController::class, 'exportExcel'])->name('export-excel');
                // Route::get('{kelas}/export/pdf', [LaporanKelasController::class, 'exportPdf'])->name('export-pdf');
             
                // Export routes
                Route::get('export/excel', [LaporanKelasController::class, 'exportExcel'])->name('export-excel');
                Route::get('export/pdf', [LaporanKelasController::class, 'exportPdf'])->name('export-pdf');
                Route::get('{kelas}/export/pdf', [LaporanKelasController::class, 'exportDetailPdf'])->name('kelas-detail-pdf');
                });
        });

        // Ranking - Semua user bisa lihat
        Route::prefix('ranking')->name('ranking.')->group(function () {
            Route::get('/', [RankingController::class, 'index'])->name('index');
            Route::get('{kelas}/per-kelas', [RankingController::class, 'perKelas'])->name('per-kelas');
            Route::get('export/excel', [RankingController::class, 'exportExcel'])->name('export-excel');
            Route::get('export/pdf', [RankingController::class, 'exportPdf'])->name('export-pdf');
        });
    });

    // =============================================
    // 8. API INTERNAL (UNTUK AJAX)
    // =============================================
    Route::prefix('api')->name('api.')->group(function () {
        // Data untuk select2/dropdown
        Route::get('siswa/search', [SiswaController::class, 'search'])->name('siswa.search');
        Route::get('guru/search', [GuruController::class, 'search'])->name('guru.search');
        Route::get('kelas/search', [KelasController::class, 'search'])->name('kelas.search');
        Route::get('pelanggaran/search', [PelanggaranController::class, 'search'])->name('pelanggaran.search');
        Route::get('prestasi/search', [PrestasiController::class, 'search'])->name('prestasi.search');
        
        // Statistik untuk dashboard
        Route::get('statistik/pelanggaran', [DashboardController::class, 'getStatistikPelanggaran'])->name('statistik.pelanggaran');
        Route::get('statistik/prestasi', [DashboardController::class, 'getStatistikPrestasi'])->name('statistik.prestasi');
    });
});

// =============================================
// 9. FALLBACK ROUTE
// =============================================
Route::fallback(function () {
    return view('errors.404');
});