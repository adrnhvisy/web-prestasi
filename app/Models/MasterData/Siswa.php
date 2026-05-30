<?php

namespace App\Models\MasterData;
use App\Models\User;
use App\Models\Operasional\KelasSiswa;
use App\Models\Operasional\InputPelanggaran;
use App\Models\Operasional\InputPrestasi;
use App\Models\Operasional\RekapPoinSiswa;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_telp',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ortu'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke KelasSiswa
    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id', 'id');
    }

    // Relasi ke input pelanggaran
    public function inputPelanggaran()
    {
        return $this->hasMany(InputPelanggaran::class, 'siswa_id', 'id');
    }

    // Relasi ke input prestasi
    public function inputPrestasi()
    {   
        return $this->hasMany(InputPrestasi::class, 'siswa_id', 'id');
    }

    // Relasi ke rekap poin
    public function rekapPoin()
    {
        return $this->hasMany(RekapPoinSiswa::class, 'siswa_id', 'id');
    }

    // Helper: ambil kelas aktif siswa
    public function getKelasAktif()
    {
        return $this->kelasSiswa()
            ->with('kelas')
            ->whereNull('tanggal_keluar')
            ->first()?->kelas;
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
            ->withPivot('tahun_ajaran_id', 'tanggal_masuk', 'tanggal_keluar')
            ->withTimestamps();
    }
}