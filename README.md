# Aplikasi Katering

Aplikasi katering berbasis Laravel untuk mengelola menu, pesanan, invoice, dan profil merchant.

## Teknologi
- Laravel
- Tailwind CSS
- Spatie Laravel Permission
- MySQL

## Instalasi

1. Clone repository:
   ```bash
   git clone <URL_REPOSITORY>
   ```

2. Masuk ke folder project:
   ```bash
   cd <NAMA_FOLDER>
   ```

3. Install dependency:
   ```bash
   composer install
   npm install
   ```

4. Salin file environment:
   ```bash
   cp .env.example .env
   ```

   Atur konfigurasi database pada file `.env`.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Jalankan migration dan seeder:
   ```bash
   php artisan migrate --seed
   ```

   **Pastikan `DatabaseSeeder.php` memanggil seeder dalam urutan yang benar**, yaitu `RolePermissionSeeder`, `UserSeeder`, lalu `CateringPermissionSeeder` agar role, akun demo, dan permission tersedia.

7. Jalankan aplikasi:
   ```bash
   npm run build
   php artisan serve
   ```

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@example.com` | `password` |
| Customer | `customer1@example.com` | `password` |
| Merchant | `merchant1@example.com` | `password` |

## Seeder

Untuk melihat data akun demo, role, dan pengaturan user, silakan periksa:

- `database/seeders/UserSeeder.php`
- `database/seeders/RolePermissionSeeder.php`
- `database/seeders/CateringPermissionSeeder.php`

Seeder membuat data awal yang diperlukan aplikasi.

## Catatan

- Pastikan database sudah dibuat dan konfigurasi `.env` sudah benar.
- Jalankan seeder sebelum login menggunakan akun demo.
- Akun demo hanya untuk kebutuhan pengujian dan pengembangan.
