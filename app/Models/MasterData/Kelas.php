<?php

namespace App\Models\MasterData;

use App\Models\Operasional\KelasSiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan_id',
        'rombel',
        'tahun_ajaran_id',
        'wali_kelas_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Relasi ke Jurusan
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id'); // belongsTo : satu kelas hanya memiliki satu jurusan
    }

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Relasi ke Guru (wali kelas)
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke KelasSiswa
     */
    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_id');
    }

    /**
     * Relasi ke siswa melalui kelas_siswa
     */
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id')
            ->withPivot('tahun_ajaran_id', 'tanggal_masuk', 'tanggal_keluar')
            ->withTimestamps();
    }


    /**
     * Helper: jumlah siswa aktif
     */
    public function getJumlahSiswaAktifAttribute()
    {
        return $this->kelasSiswa()->whereNull('tanggal_keluar')->count();
    }

    /**
     * BOOT METHOD: Auto-generate nama_kelas sebelum disimpan
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kelas) {
            if (!$kelas->nama_kelas && $kelas->tingkat && $kelas->jurusan && $kelas->rombel) {
                $kelas->nama_kelas = $kelas->tingkat . ' ' . $kelas->jurusan->kode_jurusan . ' ' . $kelas->rombel;
            }
        });

        static::updating(function ($kelas) {
            if ($kelas->isDirty(['tingkat', 'jurusan_id', 'rombel'])) {
                $kelas->load('jurusan');
                $kelas->nama_kelas = $kelas->tingkat . ' ' . $kelas->jurusan->kode_jurusan . ' ' . $kelas->rombel;
            }
        });
    }
}