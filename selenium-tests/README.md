# Selenium UI Tests — perpus-digital

Pengujian antarmuka (UI) otomatis menggunakan Python `unittest` + Selenium WebDriver.

## Prasyarat
1. Google Chrome terpasang (ChromeDriver diunduh otomatis oleh `webdriver-manager`).
2. Python 3.9+.
3. Aplikasi Laravel sedang berjalan **dan** sudah di-seed:
   ```bash
   php artisan migrate:fresh --seed
   php artisan serve            # menjalankan di http://127.0.0.1:8000
   ```

## Instalasi
```bash
cd selenium-tests
python -m venv venv
# Windows:
venv\Scripts\activate
pip install -r requirements.txt
```

## Menjalankan
```bash
# Semua test
python -m unittest discover -s . -p "test_*.py" -v

# Satu file
python -m unittest test_admin_books -v
python -m unittest test_peminjaman_security -v
```

## Struktur
```
selenium-tests/
├── config.py                     # BASE_URL & kredensial admin/user
├── base_test.py                  # setUp/tearDown + helper login
├── test_admin_books.py           # skenario sukses: admin menambah buku
└── test_peminjaman_security.py   # proteksi: user force-URL ke area admin -> 403
```

> Catatan: ubah `HEADLESS = True` di `config.py` untuk menjalankan tanpa jendela browser.
