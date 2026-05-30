<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterData\Siswa;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dengan role siswa
        $userSiswa = User::role('siswa')->get();

        if ($userSiswa->isEmpty()) {
            $this->command->error('Tidak ada user dengan role siswa. Jalankan UserSeeder dulu.');
            return;
        }

        $dataSiswa = [
            [
                'user_id' => $userSiswa[0]->id,
                'nis' => '2025001',
                'nisn' => '1234567890',
                'nama_lengkap' => 'Ahmad Fauzi',
                'tempat_lahir' => 'Pekanbaru',
                'tanggal_lahir' => '2008-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Melati No. 10, Pekanbaru',
                'no_telp' => '081234567001',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ortu' => 'Wiraswasta',
            ],
        ];

        // Jika ada lebih dari satu siswa, bisa ditambahkan
        if ($userSiswa->count() > 1) {
            $dataSiswa[] = [
                'user_id' => $userSiswa[1]->id,
                'nis' => '2025002',
                'nisn' => '1234567891',
                'nama_lengkap' => 'Citra Dewi',
                'tempat_lahir' => 'Pekanbaru',
                'tanggal_lahir' => '2008-08-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Mawar No. 15, Pekanbaru',
                'no_telp' => '081234567002',
                'nama_ayah' => 'Joko Widodo',
                'nama_ibu' => 'Ibu Joko',
                'pekerjaan_ortu' => 'PNS',
            ];
        }

        foreach ($dataSiswa as $data) {
            Siswa::create($data);
        }

        $this->command->info('Siswa seeded successfully!');
    }
}