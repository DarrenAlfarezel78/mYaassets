# Sistem Manajemen Inventaris - PT Telkomsel

Aplikasi berbasis web untuk mengelola inventaris kantor, dibangun sebagai penyelesaian *Challenge Seleksi Magang Sistem Informasi PT Telkomsel*. Aplikasi ini dirancang untuk mengatasi masalah kehilangan data aset, duplikasi pencatatan, dan mempercepat pembuatan laporan.

## Fitur Utama
- Authentication & Role Management: Terdapat 3 role (Admin, Staff, Manager).
- Master Data Barang: CRUD data barang beserta pencarian dan *pagination*.
- Sirkulasi Peminjaman: Fitur peminjaman, pengembalian otomatis (update stok), dan riwayat transaksi.
- Dashboard Analitik: Ringkasan aset dan grafik peminjaman per bulan (Chart.js).
- Bonus Fitur Terimplementasi: Export PDF, Export Excel, REST API, Upload Gambar Barang, Notifikasi Stok Menipis, dan Dark Mode.

# Spesifikasi Teknis
- PHP: 8.3.30
- Framework: Laravel 11 (Breeze)
- Database: MySQL
- Frontend: Tailwind CSS

# Cara Instalasi & Menjalankan Project

1. Clone Repository
   - git clone (https://github.com/DarrenAlfarezel78/mYaassets.git)
   - cd (mYaassets)

2. Install Dependencies
   - composer install
   - npm install

3. Setup Environment
    - Copy file .env.example menjadi .env.
    - Buka file .env dan sesuaikan koneksi database (DB_DATABASE, DB_USERNAME, dll).
    - Generate application key: **"php artisan key:generate"**

4. Migrasi & Seeder Database
    Jalankan perintah ini untuk membangun tabel dan mengisi data awal (termasuk akun role):
    - php artisan migrate:fresh --seed

5. Storage Link (Untuk Fitur Upload Gambar)
    - php artisan storage:link

6. Jalankan Aplikasi
    Buka dua terminal dan jalankan perintah ini secara bersamaan:
    - php artisan serve
    - npm run dev

# Akun Login Testing
Gunakan akun di bawah ini untuk menguji hak akses masing-masing role:

1. Admin (Full Access)
Email: admin@admin.com
Password: 12345678

2. Staff (Kelola Data Inventaris)
Email: staff@staff.com
Password: 12345678

3. Manager (Melihat Laporan)
Email: manager@manager.com
Password: 12345678