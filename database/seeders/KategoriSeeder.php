<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Pelanggaran
        $kategoriPelanggaran = [
            ['nama_kategori' => 'Ringan', 'deskripsi' => 'Pelanggaran dengan sanksi ringan'],
            ['nama_kategori' => 'Sedang', 'deskripsi' => 'Pelanggaran dengan sanksi sedang'],
            ['nama_kategori' => 'Berat', 'deskripsi' => 'Pelanggaran dengan sanksi berat'],
        ];

        foreach ($kategoriPelanggaran as $item) {
            DB::table('kategori_pelanggaran')->insert([
                'nama_kategori' => $item['nama_kategori'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Kategori Prestasi
        $kategoriPrestasi = [
            ['nama_kategori' => 'Akademik', 'deskripsi' => 'Prestasi di bidang akademik'],
            ['nama_kategori' => 'Non-Akademik', 'deskripsi' => 'Prestasi di bidang non-akademik'],
            ['nama_kategori' => 'Kejuaraan', 'deskripsi' => 'Prestasi juara lomba'],
        ];

        foreach ($kategoriPrestasi as $item) {
            DB::table('kategori_prestasi')->insert([
                'nama_kategori' => $item['nama_kategori'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Contoh Pelanggaran
        $kategoriRinganId = DB::table('kategori_pelanggaran')->where('nama_kategori', 'Ringan')->first()->id;
        $kategoriSedangId = DB::table('kategori_pelanggaran')->where('nama_kategori', 'Sedang')->first()->id;
        $kategoriBeratId = DB::table('kategori_pelanggaran')->where('nama_kategori', 'Berat')->first()->id;

        $pelanggaran = [
            ['kategori_id' => $kategoriRinganId, 'nama_pelanggaran' => 'Terlambat masuk', 'point' => 5, 'deskripsi' => 'Terlambat kurang dari 15 menit'],
            ['kategori_id' => $kategoriRinganId, 'nama_pelanggaran' => 'Tidak membawa buku', 'point' => 5, 'deskripsi' => 'Tidak membawa buku pelajaran'],
            ['kategori_id' => $kategoriSedangId, 'nama_pelanggaran' => 'Tidak masuk tanpa keterangan', 'point' => 15, 'deskripsi' => 'Alpha tanpa izin'],
            ['kategori_id' => $kategoriSedangId, 'nama_pelanggaran' => 'Membuang sampah sembarangan', 'point' => 10, 'deskripsi' => 'Membuang sampah tidak pada tempatnya'],
            ['kategori_id' => $kategoriBeratId, 'nama_pelanggaran' => 'Berkelahi', 'point' => 50, 'deskripsi' => 'Terlibat perkelahian'],
            ['kategori_id' => $kategoriBeratId, 'nama_pelanggaran' => 'Merokok di sekolah', 'point' => 50, 'deskripsi' => 'Merokok di lingkungan sekolah'],
        ];

        foreach ($pelanggaran as $item) {
            DB::table('pelanggaran')->insert([
                'kategori_id' => $item['kategori_id'],
                'nama_pelanggaran' => $item['nama_pelanggaran'],
                'point' => $item['point'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Contoh Prestasi
        $kategoriAkademikId = DB::table('kategori_prestasi')->where('nama_kategori', 'Akademik')->first()->id;
        $kategoriNonAkademikId = DB::table('kategori_prestasi')->where('nama_kategori', 'Non-Akademik')->first()->id;
        $kategoriKejuaraanId = DB::table('kategori_prestasi')->where('nama_kategori', 'Kejuaraan')->first()->id;

        $prestasi = [
            ['kategori_id' => $kategoriAkademikId, 'nama_prestasi' => 'Nilai Ujian Tertinggi', 'point' => 10, 'deskripsi' => 'Mendapat nilai tertinggi di kelas'],
            ['kategori_id' => $kategoriAkademikId, 'nama_prestasi' => 'Juara Kelas', 'point' => 15, 'deskripsi' => 'Menjadi juara kelas'],
            ['kategori_id' => $kategoriNonAkademikId, 'nama_prestasi' => 'Hadir Tepat Waktu', 'point' => 5, 'deskripsi' => 'Hadir tepat waktu selama sebulan'],
            ['kategori_id' => $kategoriNonAkademikId, 'nama_prestasi' => 'Piket Terbaik', 'point' => 5, 'deskripsi' => 'Melaksanakan piket dengan baik'],
            ['kategori_id' => $kategoriKejuaraanId, 'nama_prestasi' => 'Juara 1 Lomba', 'point' => 50, 'deskripsi' => 'Juara 1 lomba tingkat sekolah/kota'],
            ['kategori_id' => $kategoriKejuaraanId, 'nama_prestasi' => 'Juara 2 Lomba', 'point' => 30, 'deskripsi' => 'Juara 2 lomba tingkat sekolah/kota'],
        ];

        foreach ($prestasi as $item) {
            DB::table('prestasi')->insert([
                'kategori_id' => $item['kategori_id'],
                'nama_prestasi' => $item['nama_prestasi'],
                'point' => $item['point'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        }
    }
}