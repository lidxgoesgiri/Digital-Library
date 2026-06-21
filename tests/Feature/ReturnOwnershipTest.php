<?php

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — PROTEKSI KEPEMILIKAN (BorrowingController::returnBook)
|--------------------------------------------------------------------------
| Tujuan : memastikan seorang user TIDAK dapat mengembalikan (return) buku
|          milik user lain. Guard di returnBook():
|             if ($borrowing->user_id !== auth()->id()) abort(403);
|
| Berbasis State Transition: transisi terlarang (user lain -> returnBook)
| harus ditolak dengan status 403 dan tidak mengubah state peminjaman.
*/

beforeEach(function () {
    $this->pemilik = User::factory()->create(['role' => 'user']);
    $this->penyusup = User::factory()->create(['role' => 'user']);
    $this->book = Book::factory()->create(['stock' => 5]);
});

test('user lain dilarang mengembalikan buku milik orang lain (403)', function () {
    $borrowing = Borrowing::factory()->create([
        'user_id' => $this->pemilik->id,
        'book_id' => $this->book->id,
        'status'  => 'borrowed',
    ]);

    $this->actingAs($this->penyusup)
        ->post(route('user.borrowings.return', $borrowing))
        ->assertStatus(403);

    // State peminjaman tidak berubah — tetap 'borrowed', belum dikembalikan.
    $this->assertDatabaseHas('borrowings', [
        'id'          => $borrowing->id,
        'status'      => 'borrowed',
        'returned_at' => null,
    ]);
});

test('pemilik sah tetap dapat mengembalikan bukunya sendiri', function () {
    $borrowing = Borrowing::factory()->create([
        'user_id' => $this->pemilik->id,
        'book_id' => $this->book->id,
        'status'  => 'borrowed',
    ]);

    $this->actingAs($this->pemilik)
        ->from(route('user.borrowings.index'))
        ->post(route('user.borrowings.return', $borrowing))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('borrowings', [
        'id'     => $borrowing->id,
        'status' => 'returned',
    ]);
});
