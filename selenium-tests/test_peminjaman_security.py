"""
UI TEST — PROTEKSI KEAMANAN URL (Force URL oleh User biasa)

Skenario:
  1. User biasa login -> diarahkan ke /user/dashboard.
  2. User memaksa membuka URL kelola peminjaman admin (/admin/borrowings).
  3. Verifikasi sistem MENOLAK akses: halaman menampilkan '403' / 'Forbidden'
     / 'Akses ditolak' / 'Unauthorized' (AdminMiddleware -> abort(403)).
"""

import unittest

import config
from base_test import BaseTest


class TestPeminjamanSecurity(BaseTest):
    def test_user_tidak_bisa_paksa_masuk_kelola_peminjaman_admin(self):
        driver = self.driver

        # 1. Login sebagai user biasa
        self.login_as_user()
        self.assertIn("/user", driver.current_url,
                      "User biasa seharusnya diarahkan ke area /user setelah login.")

        # 2. Force URL ke halaman admin
        driver.get(f"{config.BASE_URL}/admin/borrowings")

        # 3. Verifikasi akses ditolak
        page = driver.page_source.lower()
        ditolak = any(tanda in page for tanda in [
            "403", "forbidden", "akses ditolak", "unauthorized",
        ])
        self.assertTrue(
            ditolak,
            "Sistem harus menolak akses user biasa ke /admin/borrowings "
            "(diharapkan teks 403/Forbidden/Akses ditolak)."
        )

        # Pastikan konten ASLI halaman kelola peminjaman admin TIDAK ter-render.
        # (App memakai abort(403) sehingga URL tetap /admin/borrowings, namun yang
        #  tampil hanyalah halaman 403 — subtitle admin di bawah ini tidak boleh ada.)
        self.assertNotIn("manage book borrowings", page,
                         "Konten halaman kelola peminjaman admin tidak boleh tampil bagi user biasa.")

    def test_user_tidak_bisa_paksa_masuk_form_tambah_buku_admin(self):
        driver = self.driver

        self.login_as_user()
        driver.get(f"{config.BASE_URL}/admin/books/create")

        page = driver.page_source.lower()
        ditolak = any(tanda in page for tanda in [
            "403", "forbidden", "akses ditolak", "unauthorized",
        ])
        self.assertTrue(
            ditolak,
            "User biasa tidak boleh membuka form tambah buku admin."
        )


if __name__ == "__main__":
    unittest.main(verbosity=2)
