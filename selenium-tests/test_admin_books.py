"""
UI TEST — SKENARIO SUKSES ADMIN (State Transition: Login -> Tambah Buku -> Tersimpan)

Skenario:
  1. Admin login.
  2. Sistem otomatis mengarahkan ke area admin (/admin/...).
  3. Buka form Tambah Buku (/admin/books/create).
  4. Isi data valid lalu submit.
  5. Verifikasi buku baru muncul di tabel /admin/books (cek page_source).
"""

import time
import unittest

from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import ElementClickInterceptedException

import config
from base_test import BaseTest


class TestAdminBooks(BaseTest):
    def test_admin_dapat_menambah_buku(self):
        driver = self.driver

        # 1 & 2. Login admin -> diarahkan ke area admin
        self.login_as_admin()
        self.assertIn("/admin", driver.current_url,
                      "Admin seharusnya diarahkan ke area /admin setelah login.")

        # Judul unik agar test dapat dijalankan berulang
        judul_buku = f"Buku Selenium QA {int(time.time())}"

        # 3. Buka form Tambah Buku
        driver.get(f"{config.BASE_URL}/admin/books/create")
        self.assertIn("/admin/books/create", driver.current_url)

        # 4. Isi data valid
        driver.find_element(By.ID, "title").send_keys(judul_buku)
        driver.find_element(By.ID, "author").send_keys("Penulis Otomasi")
        driver.find_element(By.ID, "isbn").send_keys(f"978-{int(time.time())}")
        driver.find_element(By.ID, "category").send_keys("Teknologi")
        driver.find_element(By.ID, "published_year").send_keys("2024")
        stock = driver.find_element(By.ID, "stock")
        stock.clear()
        stock.send_keys("15")
        driver.find_element(By.ID, "description").send_keys("Ditambahkan oleh pengujian Selenium.")

        # submit — best practice: tunggu tombol clickable, scroll ke elemen, lalu klik.
        # Selector di-scope ke FORM tambah buku (action berisi 'books') agar tidak
        # tertukar dengan tombol submit logout di navbar (yang tersembunyi).
        submit_btn = self.wait.until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "form[action*='books'] button[type='submit']"))
        )
        driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", submit_btn)
        try:
            submit_btn.click()
        except ElementClickInterceptedException:
            # Fallback bila tombol masih tertutup elemen lain (overlay/animasi)
            driver.execute_script("arguments[0].click();", submit_btn)

        # 5. Verifikasi redirect ke index & buku muncul di tabel
        self.wait.until(lambda d: "/admin/books" in d.current_url
                        and "create" not in d.current_url)

        self.assertIn(judul_buku, driver.page_source,
                      "Buku yang baru ditambahkan harus tampil di halaman daftar buku.")


if __name__ == "__main__":
    unittest.main(verbosity=2)
