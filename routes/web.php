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

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:superadmin|admin')
        ->name('admin.dashboard');

    Route::get('/dashboard/bk', [DashboardController::class, 'bkDashboard'])
        ->middleware('role:bk')
        ->name('bk.dashboard');

    Route::get('/dashboard/guru', [DashboardController::class, 'guruDashboard'])
        ->middleware('role:guru')
        ->name('guru.dashboard');

    Route::get('/dashboard/siswa', [DashboardController::class, 'siswaDashboard'])
        ->middleware('role:siswa')
        ->name('siswa.dashboard');

    Route::get('/dashboard/ortu', [DashboardController::class, 'ortuDashboard'])
        ->middleware('role:ortu')
        ->name('ortu.dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFILE (SEMUA USER)
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/', [ProfileController::class, 'index'])
            ->name('index');

        Route::put('/', [ProfileController::class, 'update'])
            ->name('update');

        Route::put('/change-password', [ProfileController::class, 'changePassword'])
            ->name('change-password');

        Route::post('/update-foto', [ProfileController::class, 'updateFoto'])
            ->name('update-foto');
    });


    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    | Superadmin + Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('master-data')
        ->name('master-data.')
        ->middleware('role:superadmin|admin')
        ->group(function () {

            Route::resource('jurusan', JurusanController::class);

            Route::resource('kelas', KelasController::class);

            Route::resource('tahun-ajaran', TahunAjaranController::class);

            Route::post(
                'tahun-ajaran/{tahun_ajaran}/activate',
                [TahunAjaranController::class, 'activate']
            )->name('tahun-ajaran.activate');

            Route::resource('guru', GuruController::class);

            Route::post(
                'guru/{guru}/reset-password',
                [GuruController::class, 'resetPassword']
            )->name('guru.reset-password');
        });


    /*
    |--------------------------------------------------------------------------
    | MASTER DATA BK
    |--------------------------------------------------------------------------
    | Superadmin + Admin + BK
    |--------------------------------------------------------------------------
    */

    Route::prefix('master-data')
        ->name('master-data.')
        ->middleware('role:superadmin|admin|bk')
        ->group(function () {

            Route::resource(
                'kategori-pelanggaran',
                KategoriPelanggaranController::class
            );

            Route::resource(
                'pelanggaran',
                PelanggaranController::class
            );

            Route::resource(
                'kategori-prestasi',
                KategoriPrestasiController::class
            );

            Route::resource(
                'prestasi',
                PrestasiController::class
            );

            Route::resource(
                'siswa',
                SiswaController::class
            );

            Route::post(
                'siswa/{siswa}/reset-password',
                [SiswaController::class, 'resetPassword']
            )->name('siswa.reset-password');

            Route::get(
                'siswa/export/excel',
                [SiswaController::class, 'exportExcel']
            )->name('siswa.export-excel');

            Route::get(
                'siswa/export/pdf',
                [SiswaController::class, 'exportPdf']
            )->name('siswa.export-pdf');
        });


    /*
    |--------------------------------------------------------------------------
    | MANAGEMENT ACCESS
    |--------------------------------------------------------------------------
    | Superadmin + Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('management-access')
        ->name('management-access.')
        ->middleware('role:superadmin|admin')
        ->group(function () {

            Route::resource('users', UserController::class);

            Route::post(
                'users/{user}/toggle-active',
                [UserController::class, 'toggleActive']
            )->name('users.toggle-active');

            Route::post(
                'users/{user}/reset-password',
                [UserController::class, 'resetPassword']
            )->name('users.reset-password');
        });


    /*
    |--------------------------------------------------------------------------
    | OPERASIONAL
    |--------------------------------------------------------------------------
    */

    Route::prefix('operasional')
        ->name('operasional.')
        ->group(function () {

            /*
            | Admin + BK
            */
            Route::middleware('role:admin|bk')->group(function () {

                Route::resource(
                    'kelas-siswa',
                    KelasSiswaController::class
                );

                Route::post(
                    'kelas-siswa/bulk-assign',
                    [KelasSiswaController::class, 'bulkAssign']
                )->name('kelas-siswa.bulk-assign');

                Route::post(
                    'kelas-siswa/{kelas_siswa}/graduate',
                    [KelasSiswaController::class, 'graduate']
                )->name('kelas-siswa.graduate');

                Route::get(
                    'kelas-siswa/export/{kelas}',
                    [KelasSiswaController::class, 'export']
                )->name('kelas-siswa.export');
            });


            /*
            | Admin + BK + Guru
            */
            Route::middleware('role:admin|bk|guru')->group(function () {

                Route::resource(
                    'input-pelanggaran',
                    InputPelanggaranController::class
                );

                Route::resource(
                    'input-prestasi',
                    InputPrestasiController::class
                );
            });


            /*
            | Superadmin + Admin
            */
            Route::middleware('role:superadmin|admin')->group(function () {

                Route::resource(
                    'log-aktivitas',
                    LogAktivitasController::class
                )->only(['index', 'show']);

                Route::delete(
                    'log-aktivitas/clear',
                    [LogAktivitasController::class, 'clear']
                )->name('log-aktivitas.clear');
            });
        });


    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')
        ->name('reports.')
        ->group(function () {

            Route::prefix('siswa')
                ->name('siswa.')
                ->group(function () {

                    Route::get(
                        'rekap',
                        [LaporanSiswaController::class, 'rekapSiswa']
                    )->name('rekap');

                    Route::get(
                        '{siswa}/detail',
                        [LaporanSiswaController::class, 'detailSiswa']
                    )->name('detail');
                });


            Route::middleware('role:admin|bk|guru')
                ->prefix('kelas')
                ->name('kelas.')
                ->group(function () {

                    Route::get(
                        'rekap',
                        [LaporanKelasController::class, 'rekapKelas']
                    )->name('rekap');

                    Route::get(
                        '{kelas}/detail',
                        [LaporanKelasController::class, 'detailKelas']
                    )->name('detail');
                });


            Route::prefix('ranking')
                ->name('ranking.')
                ->group(function () {

                    Route::get(
                        '/',
                        [RankingController::class, 'index']
                    )->name('index');

                    Route::get(
                        '{kelas}/per-kelas',
                        [RankingController::class, 'perKelas']
                    )->name('per-kelas');
                });
        });


    /*
    |--------------------------------------------------------------------------
    | API INTERNAL
    |--------------------------------------------------------------------------
    */

    Route::prefix('api')
        ->name('api.')
        ->group(function () {

            Route::get(
                'siswa/search',
                [SiswaController::class, 'search']
            )->name('siswa.search');

            Route::get(
                'guru/search',
                [GuruController::class, 'search']
            )->name('guru.search');

            Route::get(
                'kelas/search',
                [KelasController::class, 'search']
            )->name('kelas.search');

            Route::get(
                'pelanggaran/search',
                [PelanggaranController::class, 'search']
            )->name('pelanggaran.search');

            Route::get(
                'prestasi/search',
                [PrestasiController::class, 'search']
            )->name('prestasi.search');
        });
});

// =============================================
// 9. FALLBACK ROUTE
// =============================================
Route::fallback(function () {
    return view('errors.404');
});