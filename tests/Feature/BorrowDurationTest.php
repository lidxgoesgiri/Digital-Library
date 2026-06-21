<?php

use App\Models\Book;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| BLACK BOX TESTING — EQUIVALENCE PARTITIONING (EP) & BOUNDARY VALUE ANALYSIS
|--------------------------------------------------------------------------
| Fitur     : Pengajuan Peminjaman — BorrowingController::borrow()
| Endpoint  : POST route('user.books.borrow', $book)
| Aturan    : loan_duration wajib, integer, 1 <= durasi <= 30
| 1 partisi / 1 kondisi batas = 1 test()
*/

/** Helper: user biasa + buku tersedia yang siap dipinjam. */
function userDanBuku(): array
{
    $user = User::factory()->create(['role' => 'user']);
    $book = Book::factory()->create(['stock' => 5]);

    return [$user, $book];
}

function ajukanPinjam(User $user, Book $book, array $payload)
{
    return test()->actingAs($user)
        ->from(route('user.books.show', $book))
        ->post(route('user.books.borrow', $book), $payload);
}

// ===========================================================================
// EP-VALID : durasi pada partisi valid -> peminjaman dibuat
// ===========================================================================
test('EP valid - durasi 7 hari berhasil meminjam', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 7])
        ->assertRedirect(route('user.borrowings.index'));

    $this->assertDatabaseHas('borrowings', [
        'user_id' => $user->id,
        'book_id' => $book->id,
        'status'  => 'borrowed',
    ]);
});

// ===========================================================================
// EP-INVALID : durasi kosong (melanggar required)
// ===========================================================================
test('EP invalid - durasi kosong ditolak', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => ''])
        ->assertSessionHasErrors('loan_duration');

    $this->assertDatabaseCount('borrowings', 0);
});

// ===========================================================================
// EP-INVALID : durasi bukan integer
// ===========================================================================
test('EP invalid - durasi bukan angka ditolak', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 'tujuh'])
        ->assertSessionHasErrors('loan_duration');
});

// ===========================================================================
// BVA — batas valid 1..30
// ===========================================================================
test('BVA durasi - 0 (tepat di bawah batas bawah) ditolak', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 0])
        ->assertSessionHasErrors('loan_duration');
});

test('BVA durasi - 1 (tepat batas bawah) diterima', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 1])
        ->assertSessionDoesntHaveErrors('loan_duration');

    $this->assertDatabaseHas('borrowings', ['user_id' => $user->id, 'status' => 'borrowed']);
});

test('BVA durasi - 2 (tepat di atas batas bawah) diterima', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 2])
        ->assertSessionDoesntHaveErrors('loan_duration');
});

test('BVA durasi - 29 (tepat di bawah batas atas) diterima', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 29])
        ->assertSessionDoesntHaveErrors('loan_duration');
});

test('BVA durasi - 30 (tepat batas atas) diterima', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 30])
        ->assertSessionDoesntHaveErrors('loan_duration');

    $this->assertDatabaseHas('borrowings', ['user_id' => $user->id, 'status' => 'borrowed']);
});

test('BVA durasi - 31 (tepat di atas batas atas) ditolak', function () {
    [$user, $book] = userDanBuku();

    ajukanPinjam($user, $book, ['loan_duration' => 31])
        ->assertSessionHasErrors('loan_duration');
});
