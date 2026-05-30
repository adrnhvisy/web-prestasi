<?php
// app/Http/Middleware/CheckInputPelanggaran.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInputPelanggaran
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (in_array($user->hak_akses, ['superadmin', 'admin', 'bk', 'guru'])) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses untuk input pelanggaran.');
    }
}