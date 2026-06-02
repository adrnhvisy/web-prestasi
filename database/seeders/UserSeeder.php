<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MasterData\Guru;
use App\Models\MasterData\Siswa;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data yang ada (jika menggunakan refresh database)
        // User::truncate();
        // Guru::truncate();
        // Siswa::truncate();

        // 1. Super Admin
        $superAdmin = User::create([
            'nama' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@epoint.sch.id',
            'password' => Hash::make('password123'),
            'foto' => 'default.jpg',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('superadmin');

        // 2. Admin
        $admin = User::create([
            'nama' => 'Administrator Sekolah',
            'username' => 'admin',
            'email' => 'admin@epoint.sch.id',
            'password' => Hash::make('password123'),
            'foto' => 'default.jpg',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        // 3. Guru BK
        $guruBK = User::create([
            'nama' => 'Budi Santoso, S.Pd',
            'username' => 'bksantoso',
            'email' => 'bk@epoint.sch.id',
            'password' => Hash::make('password123'),
            'foto' => 'default.jpg',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $guruBK->assignRole('bk');

        // Data Guru untuk user BK
        // Guru::create([
        //     'user_id' => $guruBK->id,
        //     'nip' => '198501012010011001',
        //     'nuptk' => '1234567890123456',
        //     'nama_lengkap' => 'Budi Santoso, S.Pd',
        //     'tempat_lahir' => 'Jakarta',
        //     'tanggal_lahir' => '1985-01-01',
        //     'jenis_kelamin' => 'L',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Merdeka No. 123, Jakarta',
        //     'no_telp' => '081234567890',
        //     'pendidikan_terakhir' => 'S1 Bimbingan Konseling',
        //     'jabatan' => 'Guru BK',
        // ]);

        // 4. Guru / Wali Kelas
        // $guruWali = User::create([
        //     'nama' => 'Siti Aminah, S.Pd',
        //     'username' => 'siti.aminah',
        //     'email' => 'siti.aminah@epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'guru',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // Guru::create([
        //     'user_id' => $guruWali->id,
        //     'nip' => '198801012010011002',
        //     'nuptk' => '2234567890123456',
        //     'nama_lengkap' => 'Siti Aminah, S.Pd',
        //     'tempat_lahir' => 'Bandung',
        //     'tanggal_lahir' => '1988-01-01',
        //     'jenis_kelamin' => 'P',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Asia Afrika No. 45, Bandung',
        //     'no_telp' => '081234567891',
        //     'pendidikan_terakhir' => 'S1 Pendidikan Matematika',
        //     'jabatan' => 'Guru Matematika',
        // ]);

        // 5. Guru Tambahan
        // $guruTambahan = User::create([
        //     'nama' => 'Ahmad Fauzi, S.Pd',
        //     'username' => 'ahmad.fauzi',
        //     'email' => 'ahmad.fauzi@epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'guru',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // Guru::create([
        //     'user_id' => $guruTambahan->id,
        //     'nip' => '198901012010011003',
        //     'nuptk' => '3234567890123456',
        //     'nama_lengkap' => 'Ahmad Fauzi, S.Pd',
        //     'tempat_lahir' => 'Surabaya',
        //     'tanggal_lahir' => '1989-01-01',
        //     'jenis_kelamin' => 'L',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Tunjungan No. 78, Surabaya',
        //     'no_telp' => '081234567892',
        //     'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Inggris',
        //     'jabatan' => 'Guru Bahasa Inggris',
        // ]);

        // 6. Siswa - Laki-laki
        // $siswaLaki = User::create([
        //     'nama' => 'Muhammad Rizki',
        //     'username' => 'm.rizki',
        //     'email' => 'm.rizki@student.epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'siswa',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // Siswa::create([
        //     'user_id' => $siswaLaki->id,
        //     'nis' => '2024001',
        //     'nisn' => '0012345678',
        //     'nama_lengkap' => 'Muhammad Rizki',
        //     'tempat_lahir' => 'Jakarta',
        //     'tanggal_lahir' => '2008-05-15',
        //     'jenis_kelamin' => 'L',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Kebon Jeruk No. 10, Jakarta',
        //     'no_telp' => '081234567893',
        //     'nama_ayah' => 'Ahmad Suryadi',
        //     'nama_ibu' => 'Siti Nurjanah',
        //     'pekerjaan_ortu' => 'Wiraswasta',
        // ]);

        // // 7. Siswa - Perempuan
        // $siswaPerempuan = User::create([
        //     'nama' => 'Anisa Putri',
        //     'username' => 'anisa.putri',
        //     'email' => 'anisa.putri@student.epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'siswa',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // Siswa::create([
        //     'user_id' => $siswaPerempuan->id,
        //     'nis' => '2024002',
        //     'nisn' => '0023456789',
        //     'nama_lengkap' => 'Anisa Putri',
        //     'tempat_lahir' => 'Bandung',
        //     'tanggal_lahir' => '2008-08-20',
        //     'jenis_kelamin' => 'P',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Dago No. 25, Bandung',
        //     'no_telp' => '081234567894',
        //     'nama_ayah' => 'Dedi Kurniawan',
        //     'nama_ibu' => 'Rina Wati',
        //     'pekerjaan_ortu' => 'PNS',
        // ]);

        // // 8. Siswa Tambahan
        // $siswaTambahan = User::create([
        //     'nama' => 'Budi Prasetyo',
        //     'username' => 'budi.prasetyo',
        //     'email' => 'budi.prasetyo@student.epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'siswa',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // Siswa::create([
        //     'user_id' => $siswaTambahan->id,
        //     'nis' => '2024003',
        //     'nisn' => '0034567890',
        //     'nama_lengkap' => 'Budi Prasetyo',
        //     'tempat_lahir' => 'Surabaya',
        //     'tanggal_lahir' => '2008-11-10',
        //     'jenis_kelamin' => 'L',
        //     'agama' => 'Islam',
        //     'alamat' => 'Jl. Raya Gubeng No. 50, Surabaya',
        //     'no_telp' => '081234567895',
        //     'nama_ayah' => 'Slamet Riyadi',
        //     'nama_ibu' => 'Sri Wahyuni',
        //     'pekerjaan_ortu' => 'Guru',
        // ]);

        // // 9. Orang Tua
        // $ortu = User::create([
        //     'nama' => 'Ahmad Suryadi',
        //     'username' => 'ahmad.suryadi',
        //     'email' => 'ahmad.suryadi@ortu.epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'ortu',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // // 10. Orang Tua Tambahan
        // $ortuTambahan = User::create([
        //     'nama' => 'Dedi Kurniawan',
        //     'username' => 'dedi.kurniawan',
        //     'email' => 'dedi.kurniawan@ortu.epoint.sch.id',
        //     'password' => Hash::make('password123'),
        //     'foto' => 'default.jpg',
        //     'hak_akses' => 'ortu',
        //     'is_active' => true,
        //     'email_verified_at' => now(),
        // ]);

        // echo "Seeder users berhasil dijalankan!\n";
        // echo "Total users: " . User::count() . "\n";
        // echo "Total guru: " . Guru::count() . "\n";
        // echo "Total siswa: " . Siswa::count() . "\n";
    }
}