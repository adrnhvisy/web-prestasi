<?php

namespace App\Models\MasterData;
use App\Models\Operasional\InputPelanggaran;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $fillable = [
        'kategori_id',
        'nama_pelanggaran',
        'point',
        'deskripsi'
    ];

    protected $casts = [
        'point' => 'integer'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_id');
    }

    // Relasi ke InputPelanggaran
    public function inputPelanggaran()
    {
        return $this->hasMany(InputPelanggaran::class, 'pelanggaran_id');
    }
}