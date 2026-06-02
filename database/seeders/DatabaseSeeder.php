<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil semua seeder dalam urutan yang benar
        $this->call([

            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            TahunAjaranSeeder::class,
            JurusanSeeder::class,
            // KategoriSeeder::class,
            // SiswaSeeder::class,
            // KelasSeeder::class,
            // KategoriSeeder::class,
            UserSeeder::class,

        ]);
    }
}