<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;// Untuk soft delete : migrate

class Jurusan extends Model
{
    use SoftDeletes;

    protected $table = 'jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi'
    ]; // menentukan field mana saja yang boleh diisi / selain ini tidak boleh diisi

    // protected $guarded = ['id']; // selain id boleh di isi

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relasi ke Kelas (untuk nanti) / kalau hanya ada relasi
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id'); // hasMany : satu jurusan memiliki banyak kelas
    }
}