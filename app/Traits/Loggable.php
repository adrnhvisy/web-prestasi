<?php

namespace App\Traits;

use App\Models\Operasional\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    public function logActivity($aktivitas, $modul, $data = null)
    {
        LogAktivitas::create([
            'user_id'    => Auth::id(),
            'aktivitas'  => $aktivitas,
            'modul'      => $modul,
            'data'       => $data, // Berupa array, otomatis jadi JSON karena cast di Model
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
