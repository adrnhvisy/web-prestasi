<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // User
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Guru
            'guru.view',
            'guru.create',
            'guru.edit',
            'guru.delete',

            // Siswa
            'siswa.view',
            'siswa.create',
            'siswa.edit',
            'siswa.delete',

            // Pelanggaran
            'pelanggaran.view',
            'pelanggaran.create',
            'pelanggaran.edit',
            'pelanggaran.delete',

            // Laporan
            'laporan.view',
            'laporan.export',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}