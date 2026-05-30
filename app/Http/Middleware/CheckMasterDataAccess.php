<?php
// app/Http/Middleware/CheckMasterDataAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMasterDataAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Superadmin dan admin bisa akses semua master data
        if (in_array($user->hak_akses, ['superadmin', 'admin'])) {
            return $next($request);
        }

        // BK bisa akses data siswa dan kategorisasi
        if ($user->hak_akses === 'bk') {
            $allowedRoutes = ['siswa', 'kategori-pelanggaran', 'pelanggaran', 'kategori-prestasi', 'prestasi'];
            $currentRoute = $request->route()->getName();

            foreach ($allowedRoutes as $route) {
                if (str_contains($currentRoute, $route)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Anda tidak memiliki akses ke master data.');
    }
}