<?php

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — STATE TRANSITION (Siklus Peminjaman)
|--------------------------------------------------------------------------
| State : S0 (belum ada) -> S1 borrowed -> S2 overdue -> S3 returned
| 1 transisi = 1 skenario test()
|
|  T1 : S0 --borrow-->            S1 borrowed
|  T2 : S0 --borrow (tak tersedia/sudah pinjam)--> ditolak (tetap)
|  T3 : S1 --lewatJatuhTempo(scheduler)--> S2 overdue
|  T5 : S1 --returnBook (telat)--> S3 returned (+denda)
|  T8 : S3 --returnBook--> ditolak ("sudah dikembalikan")
*/

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->book = Book::factory()->create(['stock' => 5]);
});

// --- T1 : S0 -> S1 borrowed ------------------------------------------------
test('T1 - user meminjam buku tersedia masuk state borrowed', function () {
    $this->actingAs($this->user)
        ->post(route('user.books.borrow', $this->book), ['loan_duration' => 7])
        ->assertRedirect(route('user.borrowings.index'));

    $this->assertDatabaseHas('borrowings', [
        'user_id' => $this->user->id,
        'book_id' => $this->book->id,
        'status'  => 'borrowed',
    ]);
});

// --- T2 : S0 -> ditolak (sudah meminjam buku yang sama) --------------------
test('T2 - meminjam buku yang sedang dipinjam ditolak (tetap 1 record)', function () {
    Borrowing::factory()->create([
        'user_id' => $this->user->id,
        'book_id' => $this->book->id,
        'status'  => 'borrowed',
    ]);

    $this->actingAs($this->user)
        ->from(route('user.books.show', $this->book))
        ->post(route('user.books.borrow', $this->book), ['loan_duration' => 7])
        ->assertSessionHas('error');

    // Tetap hanya 1 record peminjaman aktif (tidak bertambah).
    $this->assertDatabaseCount('borrowings', 1);
});

// --- T3 : S1 -> S2 overdue (scheduler) -------------------------------------
test('T3 - scheduler menandai peminjaman lewat tempo menjadi overdue', function () {
    $borrowing = Borrowing::factory()->overdue(3)->create([
        'user_id' => $this->user->id,
        'book_id' => $this->book->id,
    ]);

    $this->artisan('borrowings:update-overdue')->assertSuccessful();

    $this->assertDatabaseHas('borrowings', [
        'id'     => $borrowing->id,
        'status' => 'overdue',
    ]);
});

// --- T5 : S1 -> S3 returned (terlambat -> kena denda) ----------------------
test('T5 - mengembalikan buku terlambat masuk state returned dengan denda', function () {
    $borrowing = Borrowing::factory()->overdue(4)->create([
        'user_id' => $this->user->id,
        'book_id' => $this->book->id,
    ]);

    $this->actingAs($this->user)
        ->from(route('user.borrowings.index'))
        ->post(route('user.borrowings.return', $borrowing))
        ->assertSessionHas('success');

    $borrowing->refresh();
    expect($borrowing->status)->toBe('returned');
    expect($borrowing->fine_amount)->toBeGreaterThan(0);
});

// --- T8 : S3 -> ditolak (sudah dikembalikan) -------------------------------
test('T8 - mengembalikan buku yang sudah returned ditolak', function () {
    $borrowing = Borrowing::factory()->returnedOnTime()->create([
        'user_id' => $this->user->id,
        'book_id' => $this->book->id,
    ]);

    $this->actingAs($this->user)
        ->from(route('user.borrowings.index'))
        ->post(route('user.borrowings.return', $borrowing))
        ->assertSessionHas('error');
});
