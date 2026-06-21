<?php

use App\Models\Book;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — PENGUJIAN PROTEKSI HAK AKSES (AdminMiddleware)
|--------------------------------------------------------------------------
| Tujuan : memastikan User biasa (role 'user') TIDAK dapat mengakses route
|          milik Admin, baik via GET maupun via POST. AdminMiddleware akan
|          memanggil abort(403). Guest (belum login) dialihkan ke /login.
|
| Berbasis State Transition: transisi terlarang (user -> area admin) harus
| ditolak dengan status 403.
*/

beforeEach(function () {
    $this->user  = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
});

// --- USER biasa menembak route Admin (harus 403) --------------------------

test('user biasa dilarang membuka form tambah buku admin (403)', function () {
    $this->actingAs($this->user)
        ->get(route('admin.books.create'))
        ->assertStatus(403);
});

test('user biasa dilarang membuka halaman kelola peminjaman admin (403)', function () {
    $this->actingAs($this->user)
        ->get(route('admin.borrowings.index'))
        ->assertStatus(403);
});

test('user biasa dilarang menembak POST store buku admin (403)', function () {
    $this->actingAs($this->user)
        ->post(route('admin.books.store'), [
            'title'  => 'Buku Ilegal',
            'author' => 'Hacker',
            'stock'  => 5,
        ])
        ->assertStatus(403);

    $this->assertDatabaseMissing('books', ['title' => 'Buku Ilegal']);
});

test('user biasa dilarang menembak PUT update buku admin (403)', function () {
    $book = Book::factory()->create();

    $this->actingAs($this->user)
        ->put(route('admin.books.update', $book), [
            'title'  => 'Diubah Paksa',
            'author' => 'Hacker',
            'stock'  => 5,
        ])
        ->assertStatus(403);
});

// --- GUEST (belum login) dialihkan ke login --------------------------------

test('guest yang belum login dialihkan ke halaman login', function () {
    $this->get(route('admin.books.create'))
        ->assertRedirect(route('login'));
});

// --- ADMIN sah tetap bisa mengakses (kontrol positif) ----------------------

test('admin sah dapat membuka form tambah buku (200)', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.books.create'))
        ->assertOk();
});

test('admin sah dapat membuka halaman kelola peminjaman (200)', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.borrowings.index'))
        ->assertOk();
});
