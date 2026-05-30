<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
WebPrestasi
├─ .editorconfig
├─ admin,
├─ admin@epoint.com,
├─ Adrian San,
├─ app
│  ├─ Http
│  │  └─ Controllers
│  │     ├─ Controller.php
│  │     └─ MasterData
│  │        └─ JurusanController.php
│  ├─ Models
│  │  ├─ MasterData
│  │  │  ├─ Guru.php
│  │  │  ├─ InputPelanggaran.php
│  │  │  ├─ InputPrestasi.php
│  │  │  ├─ Jurusan.php
│  │  │  ├─ kategoriPrestasi.php
│  │  │  ├─ Kelas.php
│  │  │  ├─ KelasSiswa.php
│  │  │  ├─ KetegoriPelanggaran.php
│  │  │  ├─ LogAktivitas.php
│  │  │  ├─ Pelanggaran.php
│  │  │  ├─ Prestasi.php
│  │  │  ├─ RekapPoinSiswa.php
│  │  │  ├─ Siswa.php
│  │  │  └─ TahunAjaran.php
│  │  └─ User.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_03_11_025313_create_tahun_ajaran_table.php
│  │  ├─ 2026_03_11_030015_create_jurusan_table.php
│  │  ├─ 2026_03_12_044119_create_kategori_pelanggaran_table.php
│  │  ├─ 2026_03_12_044234_create_kategori_prestasi_table.php
│  │  ├─ 2026_03_12_044442_create_roles_table.php
│  │  ├─ 2026_03_12_044627_create_permissions_table.php
│  │  ├─ 2026_03_12_044738_create_role_user_table.php
│  │  ├─ 2026_03_12_044904_create_permission_role_table.php
│  │  ├─ 2026_03_12_044957_create_guru_table.php
│  │  ├─ 2026_03_12_045100_create_siswa_table.php
│  │  ├─ 2026_03_12_045159_create_kelas_table.php
│  │  ├─ 2026_03_12_045258_create_pelanggaran_table.php
│  │  ├─ 2026_03_12_045358_create_prestasi_table.php
│  │  ├─ 2026_03_12_045510_create_kelas_siswa_table.php
│  │  ├─ 2026_03_12_045605_create_input_pelanggaran_table.php
│  │  ├─ 2026_03_12_045705_create_input_prestasi_table.php
│  │  ├─ 2026_03_12_045810_create_rekap_poin_siswa_table.php
│  │  └─ 2026_03_12_045915_create_log_aktivitas_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ default.jpg
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ assets
│  │  ├─ css
│  │  │  ├─ adminlte.css
│  │  │  ├─ adminlte.css.map
│  │  │  ├─ adminlte.min.css
│  │  │  ├─ adminlte.min.css.map
│  │  │  ├─ adminlte.rtl.css
│  │  │  ├─ adminlte.rtl.css.map
│  │  │  ├─ adminlte.rtl.min.css
│  │  │  ├─ adminlte.rtl.min.css.map
│  │  │  ├─ normalize.min.css
│  │  │  └─ paper.css
│  │  └─ js
│  │     ├─ adminlte.js
│  │     ├─ adminlte.js.map
│  │     ├─ adminlte.min.js
│  │     └─ adminlte.min.js.map
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  └─ bootstrap.js
│  └─ views
│     ├─ auth
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  └─ register.blade.php
│     ├─ dashboard
│     │  ├─ admin.blade.php
│     │  ├─ bk.blade.php
│     │  ├─ guru.blade.php
│     │  ├─ index.blade.php
│     │  └─ siswa.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ auth.blade.php
│     │  └─ main.blade.php
│     ├─ management-access
│     │  ├─ permissions
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ roles
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  ├─ permissions.blade.php
│     │  │  └─ show.blade.php
│     │  └─ users
│     │     ├─ create.blade.php
│     │     ├─ edit.blade.php
│     │     ├─ index.blade.php
│     │     └─ show.blade.php
│     ├─ master-data
│     │  ├─ guru
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ jurusan
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ kelas
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ pelanggaran
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ prestasi
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ siswa
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  └─ tahun-ajar
│     │     ├─ create.blade.php
│     │     ├─ edit.blade.php
│     │     ├─ index.blade.php
│     │     └─ show.blade.php
│     ├─ operasional
│     │  ├─ input-pelanggaran
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ input-prestasi
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ kelas-siswa
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  └─ log-aktivitas
│     │     ├─ index.blade.php
│     │     └─ show.blade.php
│     ├─ partials
│     │  ├─ alerts.blade.php
│     │  ├─ footer.blade.php
│     │  ├─ header.blade.php
│     │  └─ sidebar.blade.php
│     ├─ profile
│     │  └─ index.blade.php
│     ├─ reports
│     │  ├─ kelas
│     │  │  ├─ detail.blade.php
│     │  │  └─ rekap.blade.php
│     │  ├─ ranking
│     │  │  ├─ index.blade.php
│     │  │  └─ per-kelas.blade.php
│     │  └─ siswa
│     │     ├─ detail.blade.php
│     │     └─ rekap.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 0ed12bdba301414cddd1d59a5ffb8aef.php
│  │     ├─ 100a0a668ad8acbc5d70b6485d2086e7.php
│  │     ├─ 10b3754c50412c0058d27e4adad215b9.php
│  │     ├─ 1390546cee81c25782a65156a2f94931.php
│  │     ├─ 143419e86080f50c6a8e2cc128daf38c.php
│  │     ├─ 1ee54cfebe7377b65788eed82c982d13.php
│  │     ├─ 20f7bbf71f98b1b6394d0e839637c918.php
│  │     ├─ 2e6a06f77fbc665126b572b77ac71775.php
│  │     ├─ 3b1c1049d9a42a85e1814c5d3a1928ba.php
│  │     ├─ 3c547e4372eb8b6691ffc720f52f1af6.php
│  │     ├─ 3d7289bfbbeed0a68d7010ded2fb0c8f.php
│  │     ├─ 3fae99eacd22490eed3bc73816bd520a.php
│  │     ├─ 45f13d98faea4ced05f6c9b6d8023769.php
│  │     ├─ 4751009452923e226e2a2675a7ab1944.php
│  │     ├─ 4b9a32bccc0284983b2e56d0767c40fd.php
│  │     ├─ 4de81f902c4c06bb31384c7ab9557cba.php
│  │     ├─ 509286df8900dc5b09f609b11c4757d7.php
│  │     ├─ 54c8f4b7f73c3c4c7135dbdf9bbb2c54.php
│  │     ├─ 56157571edfeda688224c62fea902e05.php
│  │     ├─ 5ae9c74c57ee37107e49bf5763dc801d.php
│  │     ├─ 5d02d7e379c25bf6bfa68ca31a331b10.php
│  │     ├─ 5d833757919b8b22ca196596802b6b38.php
│  │     ├─ 64286666080ac855c49d38bdbaae4e49.php
│  │     ├─ 739a8160ef78354482d2d8e9057dd0eb.php
│  │     ├─ 8348fbb889d28a9000d2722208953703.php
│  │     ├─ 848dcecec3d4ba18ce5d56ccd7755956.php
│  │     ├─ 88bf8410f403431fc6145d5a56443c1b.php
│  │     ├─ 8e850114844683a03e6cc0d97696f1fc.php
│  │     ├─ 948c8a2b3baf77abab5d4b070abe93b0.php
│  │     ├─ 9600a22cf504529269fb5e03db845d50.php
│  │     ├─ 976853dc43e8592c266e0b2a5bb4f97a.php
│  │     ├─ 9a084fe1cc5b78697f82ce0b31ef9592.php
│  │     ├─ 9ce110c32db0f22f7e617006cb71818d.php
│  │     ├─ a2d637f99223e6f8bc3dfa8a9000b18b.php
│  │     ├─ a4585d8ba845f1a097bf5df4ee0d0565.php
│  │     ├─ a803edc2ac3211865ca33c5289296009.php
│  │     ├─ aac90a6fbf15dc0a9d0b699ffe848629.php
│  │     ├─ b139ea45bb3a215396f0ad0d4d2f7bb1.php
│  │     ├─ b50e41dec6aa0e21f85d88a22140d8cf.php
│  │     ├─ b6ae89ce239233106210174d99a016eb.php
│  │     ├─ b6ed77c392165dcf8129a95154fa71c6.php
│  │     ├─ bb169443316e7f53d948f8e9bc54c9f4.php
│  │     ├─ bff3fd4f52e9ca66fb1752f53c9c801f.php
│  │     ├─ ca881bed280f40f54d96d0babe15a94d.php
│  │     ├─ de97201a71d7181dbd2930461d450b45.php
│  │     ├─ e4b06fac9b8e38e72364e10f049e9425.php
│  │     ├─ e80708bd00557d9f95d0d68dbbfbfd73.php
│  │     ├─ edbb77fed533aa4d67f703392ce2fac8.php
│  │     ├─ f2c91d255a49987b89d1e66371396b56.php
│  │     ├─ f7129349748f4aabc1794ccc83c9ca83.php
│  │     ├─ f81d95c5d644338be48df930f07f9a5d.php
│  │     ├─ f9dfa222afb7631fd3a5e0eff7afd05e.php
│  │     ├─ fe8d486e42ecc62c8ba10cd2cb644e6d.php
│  │     └─ ff19f7412988cc716fcb0c7cb159d2f8.php
│  └─ logs
├─ superadmin,
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
├─ true,
└─ vite.config.js

```