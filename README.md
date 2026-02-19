 🌱 Growly - Aplikasi Pemantauan Tumbuh Kembang Anak

Growly adalah aplikasi berbasis web untuk membantu orang tua memantau pertumbuhan anak usia 0-6 tahun berdasarkan standar WHO.

 ✨ Fitur Utama

- 👶 Manajemen Anak - Tambah, edit, hapus data anak
- 📏 Pencatatan Pengukuran - Catat berat & tinggi badan
- 📊 Grafik Pertumbuhan - Visualisasi perkembangan anak
- ✅ Todo List - Checklist harian dengan streak
- 📈 Dashboard - Ringkasan statistik semua anak
- 🖼️ Upload Foto - Foto anak dengan fallback emoji
- 🔐 Autentikasi - Login/register dengan Laravel Breeze

    🛠️ Tech Stack

- Backend: Laravel 12
- Frontend: Blade + Tailwind CSS
- Database: MySQL
- Chart: Chart.js
- Auth: Laravel Breeze

    📋 Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Git

 🚀 Cara Install & Menjalankan

1. Clone Repository

git clone https://github.com/username/growly-app.git
cd growly-app

2. Install Dependensi
composer install
npm install

3. Setup Environment
.env.example
php artisan key:generate

4. Konfigurasi Database
edit file .env dan sesuaikan dengan database. contoh:
DB_DATABASE=growly_db
DB_USERNAME=root
DB_PASSWORD=

5. Migrasi DataBase
php artisan migrate

6. Membuat Storage Link
php artisan storage:link

7. Jalankan Aplikasi di terminal
npm run dev
php artisan serve