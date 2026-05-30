<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Pelanggaran;
use App\Models\MasterData\Kelas;
use App\Models\User;
use App\Models\MasterData\TahunAjaran;

class InputPelanggaran extends Model
{
    protected $table = 'input_pelanggaran';
    
    protected $fillable = [
        'kode_transaksi',
        'siswa_id',
        'pelanggaran_id',
        'kelas_id',
        'user_id',
        'tahun_ajaran_id',
        'waktu',
        'keterangan'
    ];

    protected $casts = [
        'waktu' => 'datetime',
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
     * Relasi ke Pelanggaran
     */
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Update rekap poin siswa
     */
    public function updateRekapPoin()
    {
        // Cek apakah class RekapPoinSiswa ada
        if (!class_exists('App\Models\Operasional\RekapPoinSiswa')) {
            return;
        }

        $rekap = RekapPoinSiswa::firstOrCreate([
            'siswa_id' => $this->siswa_id,
            'tahun_ajaran_id' => $this->tahun_ajaran_id
        ], [
            'kelas_id' => $this->kelas_id,
            'total_pelanggaran' => 0,
            'total_prestasi' => 0,
            'total_point_pelanggaran' => 0,
            'total_point_prestasi' => 0,
            'poin_bersih' => 0
        ]);

        $rekap->updateRekap();
    }

    /**
     * Accessor untuk menampilkan poin
     */
    public function getPoinAttribute()
    {
        return $this->pelanggaran->point ?? 0;
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeTanggalRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter siswa
     */
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    /**
     * Scope untuk filter kelas
     */
    public function scopeKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }
}