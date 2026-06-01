# 🛣️ Sulteng Lapor Jalan - Smart Mobility System

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)

**Sulteng Lapor Jalan** adalah aplikasi prototype berbasis web yang dirancang untuk mendukung dimensi **Smart Mobility** dalam program **Smart City** di Sulawesi Tengah. Website ini dirancang khusus untuk mempermudah masyarakat melaporkan kerusakan jalan secara digital, cepat, dan transparan, sekaligus memudahkan pihak berwenang (admin/pemerintah) untuk memverifikasi serta menindaklanjuti laporan tersebut.

---

## 📌 Fitur Utama

### 👥 Sisi Masyarakat (User)
* **Pendaftaran & Login Akun:** Mengamankan identitas pelapor.
* **Dashboard Interaktif:** Melihat rangkuman statistik laporan pribadi (total laporan, status proses, dll).
* **Form Pelaporan Cepat:** Mengunggah foto bukti fisik kerusakan, deskripsi, jenis kerusakan (retak, berlubang, amblas, dsb), tingkat keparahan (ringan, sedang, berat), koordinat lokasi, dan integrasi link Google Maps.
* **Riwayat Laporan:** Memantau status laporan secara real-time (*Diterima*, *Diverifikasi*, *Diproses*, *Selesai*, *Ditolak*).

### 🛠️ Sisi Pemerintah / Pengelola (Admin)
* **Dashboard Statistik:** Rangkuman visual seluruh laporan masuk untuk mempermudah prioritas penanganan.
* **Kelola Laporan:** Memverifikasi laporan masuk, memperbarui status penanganan, menambahkan catatan admin, dan menghapus laporan tidak valid.
* **Keamanan Berlapis:** Pembatasan akses berbasis hak tingkat lanjut (*Middleware Role*).

---

## 💻 Spesifikasi & Teknologi
* **Framework:** Laravel 11.x
* **Frontend Engine:** Blade Template + TailwindCSS (Laravel Breeze)
* **Database:** MySQL (XAMPP / phpMyAdmin)
* **Asset Bundler:** Vite
* **Storage:** Local Storage Laravel (Simulasi cloud storage untuk media foto)

---

## 🚀 Panduan Setup & Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di komputer lokal Anda:

### 1. Prasyarat Sistem
Pastikan Anda sudah menginstal software berikut di komputer Anda:
* [XAMPP](https://www.apachefriends.org/) (Direkomendasikan PHP versi 8.2 atau lebih tinggi)
* [Composer](https://getcomposer.org/) (Untuk mengelola dependensi PHP)
* [Node.js & NPM](https://nodejs.org/) (Untuk mengelola aset frontend/TailwindCSS)
* Git (Untuk manajemen repository)

### 2. Langkah-Langkah Instalasi

#### Langkah 1: Clone Repository
Buka terminal/command prompt Anda, lalu jalankan perintah berikut untuk meng-clone repository ini:
```bash
git clone https://github.com/TnwrulA/sulteng-lapor-jalan.git
cd sulteng-lapor-jalan
```

#### Langkah 2: Install Dependensi PHP (Composer)
Jalankan composer untuk memasang seluruh package backend Laravel:
```bash
composer install
```

#### Langkah 3: Install Dependensi Javascript (NPM)
Jalankan perintah berikut untuk mengunduh package frontend (TailwindCSS, Vite, dll):
```bash
npm install
```

#### Langkah 4: Salin dan Konfigurasi File Lingkungan (`.env`)
Salin file template `.env.example` menjadi `.env`:
* **Di Windows (PowerShell/CMD):**
  ```powershell
  copy .env.example .env
  ```
* **Di Linux/macOS:**
  ```bash
  cp .env.example .env
  ```

#### Langkah 5: Generate Application Key
Buat kunci keamanan enkripsi aplikasi Laravel Anda:
```bash
php artisan key:generate
```

#### Langkah 6: Konfigurasi Database
1. Aktifkan modul **Apache** dan **MySQL** di control panel **XAMPP** Anda.
2. Buka browser dan akses **phpMyAdmin** (`http://localhost/phpmyadmin`).
3. Buat database baru bernama: `sulteng_lapor_jalan`.
4. Buka file `.env` di text editor Anda, lalu pastikan konfigurasinya sesuai seperti di bawah ini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sulteng_lapor_jalan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

#### Langkah 7: Jalankan Migrasi Database
Jalankan migration untuk membuat tabel-tabel yang diperlukan secara otomatis di database:
```bash
php artisan migrate
```
> **Catatan:** Jika sudah ada file seeder untuk admin, Anda bisa menjalankan `php artisan db:seed` atau langsung melakukan `php artisan migrate --seed` jika ingin menyertakan data bawaan.

#### Langkah 8: Buat Storage Link (Penting untuk Upload Foto)
Agar foto laporan yang diunggah oleh user dapat diakses dan ditampilkan di browser, buat link direktori storage:
```bash
php artisan storage:link
```

#### Langkah 9: Jalankan Server Pengembangan
Anda perlu menjalankan dua server berikut secara bersamaan:

1. **Jalankan Laravel Backend Server:**
   ```bash
   php artisan serve
   ```
   Aplikasi Anda sekarang dapat diakses melalui browser di alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000).

2. **Jalankan Vite Frontend Server (Terminal terpisah):**
   ```bash
   npm run dev
   ```

---

## 📂 Struktur Penting Direktori
* `app/Http/Controllers/` : Logika bisnis dan pengolahan data.
* `app/Models/` : Definisi database dan relasi antar tabel (User, RoadReport).
* `database/migrations/` : Struktur skema database.
* `resources/views/` : Layout dan tampilan user interface (Blade Templates).
* `routes/web.php` : Pengaturan rute halaman web.

---

## 🛠️ Alur Kerja & Kontribusi Git (Github Guide)

Jika Anda ingin melakukan update atau perubahan kode, ikuti alur standar Git berikut:

1. **Pastikan Anda berada di branch utama:**
   ```bash
   git checkout main
   ```
2. **Ambil perubahan terbaru dari server (Pull):**
   ```bash
   git pull origin main
   ```
3. **Lakukan modifikasi kode.**
4. **Periksa status file yang diubah:**
   ```bash
   git status
   ```
5. **Tambahkan file yang ingin dicommit:**
   ```bash
   git add .
   ```
6. **Lakukan commit dengan pesan yang deskriptif:**
   ```bash
   git commit -m "Fitur: menambahkan petunjuk setup project di README"
   ```
7. **Kirim perubahan ke GitHub (Push):**
   ```bash
   git push origin main
   ```

---

## 👨‍💻 Kontributor & Lisensi
Project ini dibuat sebagai pemenuhan tugas ujian akhir semester (**UAS**) bertema **Smart City - Smart Mobility**.
* **Lisensi:** Open-sourced software under the [MIT license](https://opensource.org/licenses/MIT).
