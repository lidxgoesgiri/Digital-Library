<?php

use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — EQUIVALENCE PARTITIONING (EP)
|--------------------------------------------------------------------------
| Fitur     : Login (Autentikasi) — Auth\AuthenticatedSessionController::store()
| Endpoint  : POST /login   (validasi pada App\Http\Requests\Auth\LoginRequest)
| Aturan    : email    wajib, string, format email
|             password wajib, string
|             kredensial harus cocok dengan record user (Auth::attempt)
| 1 partisi = 1 test()
|
| Tabel Equivalence Partitioning:
|   ID      Field     Kelas Ekuivalensi              Jenis    Contoh             Hasil
|   EPL-01  email+pwd terdaftar & password benar     Valid    user terdaftar     Diterima (login)
|   EPL-02  email     kosong                          Invalid  ''                 Ditolak (error email)
|   EPL-03  email     format bukan email              Invalid  'bukan-email'      Ditolak (error email)
|   EPL-04  password  kosong                          Invalid  ''                 Ditolak (error password)
|   EPL-05  kredensial password salah (tak cocok)     Invalid  password keliru    Ditolak (error email, guest)
*/

// ===========================================================================
// EPL-01  VALID : email terdaftar + password benar -> terautentikasi
// ===========================================================================
test('EP valid - email terdaftar dengan password benar berhasil login', function () {
    $user = User::factory()->create([
        'email'    => 'budi@perpus.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email'    => 'budi@perpus.com',
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard', absolute: false));
});

// ===========================================================================
// EPL-02  INVALID : email kosong (melanggar required)
// ===========================================================================
test('EP invalid - email kosong ditolak', function () {
    $this->post('/login', [
        'email'    => '',
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

// ===========================================================================
// EPL-03  INVALID : email tidak berformat email (melanggar rule email)
// ===========================================================================
test('EP invalid - email tidak valid formatnya ditolak', function () {
    $this->post('/login', [
        'email'    => 'bukan-email',
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

// ===========================================================================
// EPL-04  INVALID : password kosong (melanggar required)
// ===========================================================================
test('EP invalid - password kosong ditolak', function () {
    User::factory()->create(['email' => 'siti@perpus.com']);

    $this->post('/login', [
        'email'    => 'siti@perpus.com',
        'password' => '',
    ])->assertSessionHasErrors('password');

    $this->assertGuest();
});

// ===========================================================================
// EPL-05  INVALID : kredensial salah — email terdaftar tetapi password keliru
// ===========================================================================
test('EP invalid - password salah (kredensial tidak cocok) ditolak', function () {
    User::factory()->create([
        'email'    => 'andi@perpus.com',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'email'    => 'andi@perpus.com',
        'password' => 'password-salah',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});
