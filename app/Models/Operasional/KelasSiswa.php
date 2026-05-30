<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;

class KelasSiswa extends Model
{
    protected $table = 'kelas_siswa';
    
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
        'tanggal_masuk',
        'tanggal_keluar'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Scope untuk siswa aktif (belum keluar)
     */
    public function scopeActive($query)
    {
        return $query->whereNull('tanggal_keluar');
    }

    /**
     * Scope untuk siswa yang sudah keluar (alumni)
     */
    public function scopeAlumni($query)
    {
        return $query->whereNotNull('tanggal_keluar');
    }

    /**
     * Accessor untuk status
     */
    public function getStatusAttribute()
    {
        return $this->tanggal_keluar ? 'Alumni' : 'Aktif';
    }

    /**
     * Accessor untuk badge status
     */
    public function getStatusBadgeAttribute()
    {
        return $this->tanggal_keluar 
            ? '<span class="badge bg-secondary">Alumni</span>' 
            : '<span class="badge bg-success">Aktif</span>';
    }
}