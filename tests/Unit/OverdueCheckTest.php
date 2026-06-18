<?php

use App\Models\Borrowing;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| WHITE BOX TESTING — BASIS PATH TESTING
|--------------------------------------------------------------------------
| Unit di bawah uji   : App\Models\Borrowing::hitungDenda()
| Cyclomatic V(G)     : 6  (E - N + 2 = 15 - 11 + 2 ; P + 1 = 5 + 1 ; Region = 6)
| Independent Path    : 6 jalur (P1..P6) -> 1 Path = 1 test()
|
| Pemetaan node (lihat Borrowing::hitungDenda()):
|   1  init overdueDays = 0
|   2  if status === 'returned'
|   3  if returned_at->isAfter(due_date)
|   4  overdueDays = diff(due_date, returned_at)
|   5  elseif status === 'borrowed'
|   6  if due_date->isPast()
|   7  overdueDays = diff(due_date, now)
|   8  if overdueDays > 0
|   9  return overdueDays * finePerDay
|  10  return 0
|
| Catatan: setiap test() di-fix waktunya dengan Carbon::setTestNow() agar
| deterministik (tidak bergantung pada jam eksekusi).
*/

afterEach(function () {
    Carbon::setTestNow(); // reset waktu palsu
});

/**
 * Helper: buat instance Borrowing TANPA menyentuh database.
 * Model casting ('date') tetap aktif sehingga atribut menjadi objek Carbon.
 */
function makeBorrowing(array $attributes): Borrowing
{
    return new Borrowing($attributes);
}

// ---------------------------------------------------------------------------
// PATH 1 : 1-2-3-4-8-9-11  (returned, terlambat, denda > 0)
// Buku dikembalikan 4 hari setelah due_date -> denda 4 x 1000 = 4000
// ---------------------------------------------------------------------------
test('Path 1 - buku dikembalikan terlambat menghasilkan denda', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $borrowing = makeBorrowing([
        'status'      => 'returned',
        'due_date'    => Carbon::parse('2026-06-10'),
        'returned_at' => Carbon::parse('2026-06-14'), // 4 hari terlambat
    ]);

    expect($borrowing->hitungDenda())->toBe(4000.0);
});

// ---------------------------------------------------------------------------
// PATH 2 : 1-2-3-8-10-11  (returned, tepat waktu, denda = 0)
// returned_at TIDAK setelah due_date -> overdueDays tetap 0
// ---------------------------------------------------------------------------
test('Path 2 - buku dikembalikan tepat waktu tidak kena denda', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $borrowing = makeBorrowing([
        'status'      => 'returned',
        'due_date'    => Carbon::parse('2026-06-20'),
        'returned_at' => Carbon::parse('2026-06-18'), // sebelum due_date
    ]);

    expect($borrowing->hitungDenda())->toBe(0.0);
});

// ---------------------------------------------------------------------------
// PATH 3 : 1-2-5-6-7-8-9-11  (borrowed, sudah lewat due_date, denda > 0)
// Masih 'borrowed' tetapi due_date sudah lewat 3 hari -> denda 3000
// ---------------------------------------------------------------------------
test('Path 3 - status borrowed yang melewati batas dikenai denda', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $borrowing = makeBorrowing([
        'status'   => 'borrowed',
        'due_date' => Carbon::parse('2026-06-15'), // lewat 3 hari dari "now"
    ]);

    expect($borrowing->hitungDenda())->toBe(3000.0);
});

// ---------------------------------------------------------------------------
// PATH 4 : 1-2-5-6-8-10-11  (borrowed, belum lewat due_date, denda = 0)
// ---------------------------------------------------------------------------
test('Path 4 - status borrowed yang belum jatuh tempo tidak kena denda', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $borrowing = makeBorrowing([
        'status'   => 'borrowed',
        'due_date' => Carbon::parse('2026-06-25'), // masih 7 hari lagi
    ]);

    expect($borrowing->hitungDenda())->toBe(0.0);
});

// ---------------------------------------------------------------------------
// PATH 5 : 1-2-5-8-10-11  (status bukan returned & bukan borrowed -> mis. 'overdue')
// Kedua cabang utama false -> overdueDays = 0
// ---------------------------------------------------------------------------
test('Path 5 - status selain borrowed/returned tidak diproses denda', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $borrowing = makeBorrowing([
        'status'   => 'overdue',
        'due_date' => Carbon::parse('2026-06-01'),
    ]);

    expect($borrowing->hitungDenda())->toBe(0.0);
});

// ---------------------------------------------------------------------------
// PATH 6 : 1-2-3-4-8-10-11  (returned + terlambat tetapi node 8 bernilai false)
// Jalur ini melengkapi basis set (independen secara graf) NAMUN INFEASIBLE:
// jika node 3 true maka overdueDays pasti > 0, sehingga node 8 tidak mungkin
// false. Didokumentasikan & ditandai skip sesuai kaidah Basis Path Testing.
// ---------------------------------------------------------------------------
test('Path 6 - jalur infeasible (terlambat namun denda nol)', function () {
    expect(true)->toBeTrue();
})->skip('Infeasible path: node 3 (terlambat) selalu memaksa overdueDays > 0, sehingga node 8 tak mungkin false. Tetap dihitung dalam basis set V(G)=6.');
