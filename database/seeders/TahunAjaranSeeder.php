<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_ajaran')->insert([
            [
                'nama' => '2025/2026',
                'semester' => 'Ganjil',
                'tanggal_mulai' => '2025-07-15',
                'tanggal_selesai' => '2025-12-20',
                'is_aktif' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ],
            [
                'nama' => '2025/2026',
                'semester' => 'Genap',
                'tanggal_mulai' => '2026-01-10',
                'tanggal_selesai' => '2026-06-25',
                'is_aktif' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]
        ]);
    }
}