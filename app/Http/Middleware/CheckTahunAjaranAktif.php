<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterData\TahunAjaran;

class CheckTahunAjaranAktif
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip untuk route tertentu (misalnya route yang tidak memerlukan tahun ajaran)
        $excludedRoutes = [
            'login',
            'logout',
            'dashboard',
            'master-data.tahun-ajaran.*',
        ];

        foreach ($excludedRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }

        if (Auth::check()) {
            $tahunAjaranAktif = TahunAjaran::getActive();

            if (!$tahunAjaranAktif) {
                return redirect()->route('master-data.tahun-ajaran.index')
                    ->with('warning', 'Belum ada tahun ajaran yang aktif. Silakan aktifkan tahun ajaran terlebih dahulu.');
            }

            // Share ke semua view
            view()->share('tahunAjaranAktif', $tahunAjaranAktif);
        }

        return $next($request);
    }
}