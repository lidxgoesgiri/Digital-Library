<?php

use App\Models\Book;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — BOUNDARY VALUE ANALYSIS (BVA)
|--------------------------------------------------------------------------
| Fitur     : Edit / Update Buku (Admin) — Admin\BookController::update()
| Endpoint  : PUT route('admin.books.update', $book)  ->  /admin/books/{book}
| Aturan    : title  wajib, string, max 255
|             stock  wajib, integer, 1 <= stock <= 50
|             published_year nullable, integer, 1900 <= tahun <= tahun berjalan
|             isbn   nullable, unique kecuali milik buku itu sendiri
| 1 kondisi batas = 1 test()
|
| Tabel BVA field `stock` (batas valid 1..50):
|   No   Nilai  Posisi                       Expected
|   1    0      tepat di bawah batas bawah    Ditolak
|   2    1      tepat batas bawah             Diterima
|   3    50     tepat batas atas             Diterima
|   4    51     tepat di atas batas atas      Ditolak
|
| Tabel BVA field `published_year` (batas valid 1900..tahun berjalan):
|   No   Nilai             Posisi                   Expected
|   5    1899              di bawah batas bawah      Ditolak
|   6    tahun berjalan    tepat batas atas         Diterima
*/

/** Helper: admin terotentikasi. */
function adminUntukUpdate(): User
{
    return User::factory()->create(['role' => 'admin']);
}

/** Helper: payload update valid untuk sebuah buku (isbn = milik buku itu sendiri). */
function payloadUpdate(Book $book, array $override = []): array
{
    return array_merge([
        'title'          => 'Judul Hasil Edit',
        'author'         => 'Penulis Edit',
        'isbn'           => $book->isbn,
        'category'       => 'Teknologi',
        'published_year' => 2010,
        'stock'          => 15,
        'description'    => 'Deskripsi setelah diedit.',
    ], $override);
}

beforeEach(function () {
    $this->admin = adminUntukUpdate();
    $this->book  = Book::factory()->create(['title' => 'Judul Lama', 'stock' => 5]);
});

// ===========================================================================
// EP-VALID : update dengan data valid -> tersimpan & judul berubah
// ===========================================================================
test('EP valid - update data valid mengubah buku', function () {
    $response = $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book));

    $response->assertRedirect(route('admin.books.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('books', [
        'id'    => $this->book->id,
        'title' => 'Judul Hasil Edit',
        'stock' => 15,
    ]);
});

// ===========================================================================
// STOCK — Boundary Value Analysis (batas valid 1..50)
// ===========================================================================
test('BVA stock - nilai 0 (tepat di bawah batas bawah) ditolak', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['stock' => 0]))
        ->assertSessionHasErrors('stock');
});

test('BVA stock - nilai 1 (tepat batas bawah) diterima', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['stock' => 1]))
        ->assertSessionDoesntHaveErrors('stock');

    $this->assertDatabaseHas('books', ['id' => $this->book->id, 'stock' => 1]);
});

test('BVA stock - nilai 50 (tepat batas atas) diterima', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['stock' => 50]))
        ->assertSessionDoesntHaveErrors('stock');

    $this->assertDatabaseHas('books', ['id' => $this->book->id, 'stock' => 50]);
});

test('BVA stock - nilai 51 (tepat di atas batas atas) ditolak', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['stock' => 51]))
        ->assertSessionHasErrors('stock');
});

// ===========================================================================
// PUBLISHED_YEAR — Boundary Value Analysis (batas valid 1900..tahun berjalan)
// ===========================================================================
test('BVA tahun - 1899 (tepat di bawah batas bawah) ditolak', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['published_year' => 1899]))
        ->assertSessionHasErrors('published_year');
});

test('BVA tahun - tahun berjalan (tepat batas atas) diterima', function () {
    $this->actingAs($this->admin)
        ->from(route('admin.books.edit', $this->book))
        ->put(route('admin.books.update', $this->book), payloadUpdate($this->book, ['published_year' => (int) date('Y')]))
        ->assertSessionDoesntHaveErrors('published_year');
});
