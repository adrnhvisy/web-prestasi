<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
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
        if (Auth::check()) {
            $user = Auth::user();
            
            // Cek apakah user aktif (is_active = true)
            if (!$user->is_active) {
                Auth::logout();
                
                return redirect()->route('login')
                    ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}