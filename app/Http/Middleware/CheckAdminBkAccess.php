<?php
// app/Http/Middleware/CheckAdminBkAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminBkAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(Auth::user()->hak_akses, ['superadmin', 'admin', 'bk'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}