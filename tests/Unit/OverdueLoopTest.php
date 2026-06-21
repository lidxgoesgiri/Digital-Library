<?php

use App\Models\Borrowing;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| WHITE BOX TESTING — BASIS PATH TESTING (DENGAN LOOP)
|--------------------------------------------------------------------------
| Unit di bawah uji   : App\Models\Borrowing::tandaiOverdue()
|   (versi terstruktur dari perulangan pada
|    App\Console\Commands\UpdateOverdueBorrowings::handle())
|
| Cyclomatic V(G)     : 3  (E - N + 2 = 6 - 5 + 2 ; P + 1 = 2 + 1 ; Region = 3)
| Independent Path    : 3 jalur (P1..P3) -> 1 Path = 1 test()
|
| Pemetaan node (lihat Borrowing::tandaiOverdue()):
|   1  init ditandai = []
|   2  foreach (loop)  -> predikat perulangan
|   3  if dueDate < today
|   4  ditandai[] = id
|   5  return ditandai
|
| Daftar edge (E=6): 1->2, 2->3, 2->5, 3->4, 3->2, 4->2
| Predikat (P=2)   : node 2 (loop), node 3 (if)
|
| Cakupan loop: P1 = 0 iterasi, P2 = 1 iterasi (false), P3 = 1 iterasi (true).
*/

afterEach(function () {
    Carbon::setTestNow();
});

// ---------------------------------------------------------------------------
// PATH 1 : 1-2-5  (loop 0 kali — daftar kosong, tidak ada yang ditandai)
// ---------------------------------------------------------------------------
test('Path 1 - daftar kosong tidak menandai apa pun (loop nol iterasi)', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $hasil = Borrowing::tandaiOverdue([], Carbon::parse('2026-06-18'));

    expect($hasil)->toBe([]);
});

// ---------------------------------------------------------------------------
// PATH 2 : 1-2-3-2-5  (loop 1 kali, kondisi FALSE — belum lewat batas)
// ---------------------------------------------------------------------------
test('Path 2 - peminjaman belum jatuh tempo tidak ditandai overdue', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $hasil = Borrowing::tandaiOverdue([
        ['id' => 1, 'due_date' => '2026-06-25'], // masih akan datang
    ], Carbon::parse('2026-06-18'));

    expect($hasil)->toBe([]);
});

// ---------------------------------------------------------------------------
// PATH 3 : 1-2-3-4-2-5  (loop 1 kali, kondisi TRUE — sudah lewat batas)
// ---------------------------------------------------------------------------
test('Path 3 - peminjaman lewat jatuh tempo ditandai overdue', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $hasil = Borrowing::tandaiOverdue([
        ['id' => 7, 'due_date' => '2026-06-10'], // sudah lewat
    ], Carbon::parse('2026-06-18'));

    expect($hasil)->toBe([7]);
});

// ---------------------------------------------------------------------------
// PELENGKAP : loop banyak iterasi (campuran) — memperkuat cakupan perulangan
// Bukan jalur basis baru, namun membuktikan loop bekerja untuk N > 1.
// ---------------------------------------------------------------------------
test('Loop banyak iterasi - hanya yang lewat batas yang ditandai', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-18'));

    $hasil = Borrowing::tandaiOverdue([
        ['id' => 1, 'due_date' => '2026-06-10'], // lewat   -> ditandai
        ['id' => 2, 'due_date' => '2026-06-25'], // belum   -> tidak
        ['id' => 3, 'due_date' => '2026-06-01'], // lewat   -> ditandai
    ], Carbon::parse('2026-06-18'));

    expect($hasil)->toBe([1, 3]);
});
