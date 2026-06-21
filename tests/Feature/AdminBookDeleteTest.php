<?php

use App\Models\Book;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — STATE TRANSITION
|--------------------------------------------------------------------------
| Fitur     : Hapus Buku (Admin) — Admin\BookController::destroy()
| Endpoint  : DELETE route('admin.books.destroy', $book)  ->  /admin/books/{book}
|
| State buku terhadap basis data:
|   S0 = Buku ADA di database
|   S1 = Buku TERHAPUS dari database
|
| Tabel Transisi State:
|   No   State Awal   Event / Aksi          Guard            State Akhir   Output
|   D1   S0 (ada)     destroy (role admin)  role = admin     S1 (terhapus) redirect + success
|   D2   S0 (ada)     destroy (role user)   bukan admin      S0 (tetap)    403, buku tetap ada
|   D3   S1 (—)       destroy id tak ada    record absen     S1            404 (model binding gagal)
*/

/** Helper: admin terotentikasi. */
function adminUntukDelete(): User
{
    return User::factory()->create(['role' => 'admin']);
}

// ===========================================================================
// D1 : S0 (ada) --destroy oleh admin--> S1 (terhapus)
// ===========================================================================
test('D1 - admin menghapus buku memindahkan state ada -> terhapus', function () {
    $admin = adminUntukDelete();
    $book  = Book::factory()->create();

    $this->assertDatabaseHas('books', ['id' => $book->id]); // pra-kondisi: S0 (ada)

    $response = $this->actingAs($admin)
        ->delete(route('admin.books.destroy', $book));

    $response->assertRedirect(route('admin.books.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('books', ['id' => $book->id]); // S1 (terhapus)
});

// ===========================================================================
// D2 : S0 (ada) --destroy oleh user biasa--> S0 (tetap, ditolak 403)
// Guard hak akses (AdminMiddleware) menahan transisi.
// ===========================================================================
test('D2 - user biasa tidak bisa menghapus buku (state tetap ada)', function () {
    $user = User::factory()->create(['role' => 'user']);
    $book = Book::factory()->create();

    $this->actingAs($user)
        ->delete(route('admin.books.destroy', $book))
        ->assertStatus(403);

    $this->assertDatabaseHas('books', ['id' => $book->id]); // state tidak berubah
});

// ===========================================================================
// D3 : menghapus buku yang tidak ada -> 404 (route model binding gagal)
// ===========================================================================
test('D3 - menghapus buku yang tidak ada menghasilkan 404', function () {
    $admin = adminUntukDelete();

    $this->actingAs($admin)
        ->delete(route('admin.books.destroy', 99999))
        ->assertStatus(404);
});
