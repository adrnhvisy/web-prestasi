<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Jurusan;
use App\Models\MasterData\TahunAjaran;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = Jurusan::all();
        $tahunAjaranAktif = TahunAjaran::getActive();

        if ($jurusan->isEmpty() || !$tahunAjaranAktif) {
            $this->command->error('Data jurusan atau tahun ajaran tidak ditemukan.');
            return;
        }

        $kelasData = [];

        foreach ($jurusan as $j) {
            // Untuk setiap jurusan, buat 2 rombel per tingkat
            foreach (['X', 'XI', 'XII'] as $tingkat) {
                for ($rombel = 1; $rombel <= 2; $rombel++) {
                    $kelasData[] = [
                        'nama_kelas' => $tingkat . ' ' . $j->kode_jurusan . ' ' . $rombel,
                        'tingkat' => $tingkat,
                        'jurusan_id' => $j->id,
                        'rombel' => $rombel,
                        'tahun_ajaran_id' => $tahunAjaranAktif->id,
                        'wali_kelas_id' => null,
                    ];
                }
            }
        }

        foreach ($kelasData as $data) {
            Kelas::create($data);
        }

        $this->command->info('Kelas seeded successfully!');
    }
}