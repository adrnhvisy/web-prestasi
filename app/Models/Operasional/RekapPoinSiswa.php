<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Siswa;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;

class RekapPoinSiswa extends Model
{
    protected $table = 'rekap_poin_siswa';
    
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
        'total_pelanggaran',
        'total_prestasi',
        'total_point_pelanggaran',
        'total_point_prestasi',
        'poin_bersih'
    ];

    protected $casts = [
        'total_pelanggaran' => 'integer',
        'total_prestasi' => 'integer',
        'total_point_pelanggaran' => 'integer',
        'total_point_prestasi' => 'integer',
        'poin_bersih' => 'integer'
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke TahunAjaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    // Helper: update rekap berdasarkan data transaksi
    public function updateRekap()
    {
        $pelanggaran = InputPelanggaran::where('siswa_id', $this->siswa_id)
                                       ->where('tahun_ajaran_id', $this->tahun_ajaran_id)
                                       ->get();
        
        $prestasi = InputPrestasi::where('siswa_id', $this->siswa_id)
                                 ->where('tahun_ajaran_id', $this->tahun_ajaran_id)
                                 ->get();

        $this->total_pelanggaran = $pelanggaran->count();
        $this->total_prestasi = $prestasi->count();
        $this->total_point_pelanggaran = $pelanggaran->sum(function($item) {
            return $item->pelanggaran->point ?? 0;
        });
        $this->total_point_prestasi = $prestasi->sum(function($item) {
            return $item->prestasi->point ?? 0;
        });
        $this->poin_bersih = $this->total_point_prestasi - $this->total_point_pelanggaran;
        
        $this->save();
    }

    // Helper: ranking
    public function scopeRanking($query, $kelasId = null, $tahunAjaranId = null)
    {
        $query = $query->where('tahun_ajaran_id', $tahunAjaranId ?? TahunAjaran::getActive()?->id);
        
        if ($kelasId) {
            $query = $query->where('kelas_id', $kelasId);
        }
        
        return $query->orderBy('poin_bersih', 'desc');
    }
}