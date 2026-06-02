<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([

            // Laravel
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // Spatie
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,

            // Custom
            'check.user.active' => \App\Http\Middleware\CheckUserActive::class,
            'check.tahunajaran.aktif' => \App\Http\Middleware\CheckTahunAjaranAktif::class,
            'check.admin.access' => \App\Http\Middleware\CheckAdminAccess::class,
            'check.admin.bk.access' => \App\Http\Middleware\CheckAdminBkAccess::class,
            'check.master-data.access' => \App\Http\Middleware\CheckMasterDataAccess::class,
            'check.input.pelanggaran' => \App\Http\Middleware\CheckInputPelanggaran::class,
            'check.input.prestasi' => \App\Http\Middleware\CheckInputPrestasi::class,
            'check.kelas.report' => \App\Http\Middleware\CheckKelasReport::class,
            'can:superadmin.only' => \App\Http\Middleware\SuperAdminOnly::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();