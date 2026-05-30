<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif' => 'boolean'
    ];

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'tahun_ajaran_id');
    }

    // Helper: ambil tahun ajaran aktif
    public static function getActive()
    {
        return self::where('is_aktif', true)->first();
    }

    // Helper: set tahun ajaran aktif
    public static function setActive($id)
    {
        self::query()->update(['is_aktif' => false]);
        return self::where('id', $id)->update(['is_aktif' => true]);
    }

    public function getTahunAjaranAttribute()
    {
        // Ini akan menggabungkan kolom 'nama' dan 'semester' 
        // menjadi satu string saat dipanggil
        return "{$this->nama} - {$this->semester}";
    }
}
