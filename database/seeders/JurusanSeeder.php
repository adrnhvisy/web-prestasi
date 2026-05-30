<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = [
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Jurusan yang mempelajari pengembangan perangkat lunak'],
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer dan Jaringan', 'deskripsi' => 'Jurusan yang mempelajari jaringan komputer'],
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga', 'deskripsi' => 'Jurusan yang mempelajari akuntansi'],
            ['kode_jurusan' => 'TKRO', 'nama_jurusan' => 'Teknik Kendaraan Ringan Otomotif', 'deskripsi' => 'Jurusan yang mempelajari kendaraan roda empat'],
            ['kode_jurusan' => 'TBSM', 'nama_jurusan' => 'Teknik Bisnis Sepeda Motor', 'deskripsi' => 'Jurusan yang mempelajari kendaraan roda dua'],
        ];

        foreach ($jurusan as $item) {
            DB::table('jurusan')->insert([
                'kode_jurusan' => $item['kode_jurusan'],
                'nama_jurusan' => $item['nama_jurusan'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        }
    }
}