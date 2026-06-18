<?php

use App\Models\Book;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — EQUIVALENCE PARTITIONING (EP) & BOUNDARY VALUE ANALYSIS (BVA)
|--------------------------------------------------------------------------
| Fitur     : Tambah Buku (Admin) — Admin\BookController::store()
| Endpoint  : POST route('admin.books.store')  ->  /admin/books
| Aturan    : title  wajib diisi (string, max 255)
|             author wajib diisi (string, max 255)
|             stock  wajib, integer, 1 <= stock <= 50
|             published_year nullable, integer, 1900 <= tahun <= tahun berjalan
|             isbn   nullable, unique
| 1 partisi / 1 kondisi batas = 1 test()
*/

/** Helper: data valid baku, dapat dioverride per-skenario. */
function validBookPayload(array $override = []): array
{
    return array_merge([
        'title'          => 'Clean Code',
        'author'         => 'Robert C. Martin',
        'isbn'           => '978-000-111-222',
        'category'       => 'Teknologi',
        'published_year' => 2008,
        'stock'          => 10,
        'description'    => 'Buku tentang menulis kode yang bersih.',
    ], $override);
}

/** Helper: login sebagai admin. */
function actingAsAdmin(): User
{
    return User::factory()->create(['role' => 'admin']);
}

beforeEach(function () {
    $this->admin = actingAsAdmin();
});

// ===========================================================================
// EP-VALID : seluruh field berada pada partisi valid -> buku tersimpan
// ===========================================================================
test('EP valid - data lengkap & valid berhasil menyimpan buku', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload());

    $response->assertRedirect(route('admin.books.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('books', [
        'title'  => 'Clean Code',
        'author' => 'Robert C. Martin',
        'stock'  => 10,
    ]);
});

// ===========================================================================
// EP-INVALID : TITLE
// ===========================================================================
test('EP invalid - title kosong ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['title' => '']));

    $response->assertSessionHasErrors('title');
    $this->assertDatabaseCount('books', 0);
});

// ===========================================================================
// EP-INVALID : AUTHOR
// ===========================================================================
test('EP invalid - author kosong ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['author' => '']));

    $response->assertSessionHasErrors('author');
});

// ===========================================================================
// STOCK — Boundary Value Analysis (batas valid 1..50)
// ===========================================================================

test('BVA stock - nilai 0 (tepat di bawah batas bawah) ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['stock' => 0]));

    $response->assertSessionHasErrors('stock');
});

test('BVA stock - nilai 1 (tepat batas bawah) diterima', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['stock' => 1, 'isbn' => '978-aaa-1']));

    $response->assertSessionDoesntHaveErrors('stock');
    $this->assertDatabaseHas('books', ['title' => 'Clean Code', 'stock' => 1]);
});

test('BVA stock - nilai 50 (tepat batas atas) diterima', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['stock' => 50, 'isbn' => '978-aaa-2']));

    $response->assertSessionDoesntHaveErrors('stock');
    $this->assertDatabaseHas('books', ['stock' => 50]);
});

test('BVA stock - nilai 51 (tepat di atas batas atas) ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['stock' => 51]));

    $response->assertSessionHasErrors('stock');
});

test('EP invalid - stock bukan integer ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['stock' => 'sepuluh']));

    $response->assertSessionHasErrors('stock');
});

// ===========================================================================
// PUBLISHED_YEAR — Boundary Value Analysis (batas valid 1900..tahun berjalan)
// ===========================================================================

test('BVA tahun - 1899 (tepat di bawah batas bawah) ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['published_year' => 1899]));

    $response->assertSessionHasErrors('published_year');
});

test('BVA tahun - 1900 (tepat batas bawah) diterima', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['published_year' => 1900, 'isbn' => '978-yyy-1']));

    $response->assertSessionDoesntHaveErrors('published_year');
});

test('BVA tahun - tahun berjalan (batas atas) diterima', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['published_year' => (int) date('Y'), 'isbn' => '978-yyy-2']));

    $response->assertSessionDoesntHaveErrors('published_year');
});

test('BVA tahun - tahun depan (di atas batas atas) ditolak', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['published_year' => (int) date('Y') + 1]));

    $response->assertSessionHasErrors('published_year');
});

// ===========================================================================
// EP-INVALID : ISBN unik
// ===========================================================================
test('EP invalid - isbn duplikat ditolak', function () {
    Book::factory()->create(['isbn' => '978-dup-000']);

    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.create'))
        ->post(route('admin.books.store'), validBookPayload(['isbn' => '978-dup-000']));

    $response->assertSessionHasErrors('isbn');
});
