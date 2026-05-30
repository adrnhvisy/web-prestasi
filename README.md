## Persyaratan
1. PHP (versi 8.3): `https://php.net`
2. Composer: `https://getcomposer.org`
3. Git (opsional): `https://git-scm.com`

## Tahapan Instalasi & Penggunaan
1. Download project menggunakan git dengan perintah: `git clone https://github.com/adrnhvisy/web-prestasi.git` lalu masuk ke dalam `folder project` atau download secara manual
2. Install dependency:  `composer update` dan `composer install`
3. Copy file environment: `cp .env.example .env` atau `copy .env.example .env`
4. Konfigurasi database pada .env : `sqlite` atau `mysql` 
5. Generate application key: `php artisan key:generate`
6. Storage link: `php artisan storage:link`
7. Jalankan migration: `php artisan migrate --seed`
8. Jalankan project: `php artisan serve`
9. Akses ke dashboard: `127.0.0.1:8000/login`, login menggunakan email: `superadmin@epoint.sch.id` password: `password123`
