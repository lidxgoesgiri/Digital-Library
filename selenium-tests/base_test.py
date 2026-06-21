"""
Base TestCase untuk seluruh pengujian UI Selenium.

Menyediakan:
- setUp()  : inisialisasi Chrome via webdriver-manager + implicitly_wait
- tearDown(): menutup browser
- login()  : fungsi helper login melalui form /login
- login_as_admin() / login_as_user(): shortcut kredensial
"""

import unittest

from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager

import config


class BaseTest(unittest.TestCase):
    def setUp(self):
        options = Options()
        if config.HEADLESS:
            options.add_argument("--headless=new")
        options.add_argument("--window-size=1366,768")
        options.add_argument("--disable-gpu")
        options.add_argument("--no-sandbox")

        self.driver = webdriver.Chrome(
            service=Service(ChromeDriverManager().install()),
            options=options,
        )
        self.driver.implicitly_wait(config.IMPLICIT_WAIT)
        self.wait = WebDriverWait(self.driver, config.EXPLICIT_WAIT)

    def tearDown(self):
        if hasattr(self, "driver") and self.driver:
            self.driver.quit()

    # ----------------------------------------------------------------- helpers
    def login(self, email, password):
        """Login melalui form /login dan tunggu hingga keluar dari halaman login."""
        driver = self.driver
        driver.get(f"{config.BASE_URL}/login")

        driver.find_element(By.ID, "email").clear()
        driver.find_element(By.ID, "email").send_keys(email)
        driver.find_element(By.ID, "password").clear()
        driver.find_element(By.ID, "password").send_keys(password)
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

        # Tunggu redirect: URL tidak lagi mengandung '/login'
        self.wait.until(lambda d: "/login" not in d.current_url)

    def login_as_admin(self):
        self.login(config.ADMIN_EMAIL, config.ADMIN_PASSWORD)

    def login_as_user(self):
        self.login(config.USER_EMAIL, config.USER_PASSWORD)
