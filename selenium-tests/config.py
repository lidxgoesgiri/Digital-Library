"""
Konfigurasi terpusat untuk pengujian UI Selenium proyek perpus-digital.

Ubah BASE_URL sesuai alamat server lokal Anda (default `php artisan serve`).
Kredensial diambil dari database/seeders/AdminSeeder.php.
"""

# Alamat aplikasi yang sedang berjalan (jalankan: php artisan serve)
BASE_URL = "http://127.0.0.1:8000"

# Kredensial Admin (lihat AdminSeeder.php)
ADMIN_EMAIL = "admin@perpus.com"
ADMIN_PASSWORD = "password"

# Kredensial User biasa (lihat AdminSeeder.php)
USER_EMAIL = "user@perpus.com"
USER_PASSWORD = "password"

# Waktu tunggu implisit (detik) untuk pencarian elemen
IMPLICIT_WAIT = 10

# Waktu tunggu eksplisit maksimum (detik)
EXPLICIT_WAIT = 15

# Jalankan browser tanpa tampilan (True) atau dengan tampilan (False)
HEADLESS = False
