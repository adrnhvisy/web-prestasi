<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class KategoriPrestasi extends Model
{
    protected $table = 'kategori_prestasi';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    // Relasi ke Prestasi
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'kategori_id');
    }
}