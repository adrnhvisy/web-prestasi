<?php

namespace App\Models\Operasional;

use App\Models\MasterData\Siswa;
use App\Models\MasterData\Prestasi; // Pastikan Model Prestasi sudah ada
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InputPrestasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'input_prestasi';

    protected $fillable = [
        'kode_transaksi',
        'siswa_id',
        'prestasi_id',
        'kelas_id',
        'user_id',
        'tahun_ajaran_id',
        'waktu',
        'keterangan'
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Master Prestasi
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class);
    }

    // Relasi ke Kelas saat meraih prestasi
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke User (Guru/Admin) yang menginput
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Tahun Ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
