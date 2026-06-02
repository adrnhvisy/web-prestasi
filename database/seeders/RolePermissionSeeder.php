<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::findByName('superadmin');

        $superAdmin->givePermissionTo(
            \Spatie\Permission\Models\Permission::all()
        );

        $admin = Role::findByName('admin');

        $admin->givePermissionTo([
            'user.view',
            'user.create',
            'user.edit',
            'guru.view',
            'guru.create',
            'guru.edit',
            'siswa.view',
            'siswa.create',
            'siswa.edit',
        ]);

        $bk = Role::findByName('bk');

        $bk->givePermissionTo([
            'siswa.view',
            'pelanggaran.view',
            'pelanggaran.create',
            'pelanggaran.edit',
            'laporan.view',
        ]);
    }
}