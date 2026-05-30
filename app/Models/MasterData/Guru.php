<?php

namespace App\Models\MasterData;
use App\Models\User;
use App\Models\Operasional\InputPelanggaran;
use App\Models\Operasional\InputPrestasi;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nuptk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_telp',
        'pendidikan_terakhir',
        'jabatan',
        'email'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi sebagai wali kelas
    public function waliKelas()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id', 'id');
    }

    // Relasi ke input pelanggaran
    public function inputPelanggaran()
    {
        return $this->hasMany(InputPelanggaran::class, 'guru_id', 'id');
    }

    // Relasi ke input prestasi
    public function inputPrestasi()
    {
        return $this->hasMany(InputPrestasi::class, 'guru_id', 'id');
    }
}