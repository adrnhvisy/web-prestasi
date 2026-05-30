<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    protected $table = 'kategori_pelanggaran';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    // Relasi ke Pelanggaran
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'kategori_id');
    }
}