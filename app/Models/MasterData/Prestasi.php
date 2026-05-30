<?php

namespace App\Models\MasterData;
use App\Models\Operasional\InputPrestasi;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = [
        'kategori_id',
        'nama_prestasi',
        'point',
        'deskripsi'
    ];

    protected $casts = [
        'point' => 'integer'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_id');
    }

    // Relasi ke InputPrestasi
    public function inputPrestasi()
    {
        return $this->hasMany(InputPrestasi::class, 'prestasi_id');
    }
}