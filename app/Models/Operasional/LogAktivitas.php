<?php

namespace App\Models\Operasional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogAktivitas extends Model
{
    use SoftDeletes;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'modul',
        'data',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'data' => 'array', // Memudahkan akses data JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
