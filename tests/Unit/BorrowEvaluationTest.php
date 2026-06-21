<?php

use App\Models\Borrowing;

/*
|--------------------------------------------------------------------------
| WHITE BOX TESTING — BASIS PATH TESTING (PREDIKAT MAJEMUK)
|--------------------------------------------------------------------------
| Unit di bawah uji   : App\Models\Borrowing::evaluasiPeminjaman()
|   (versi terstruktur dari guard pada BorrowingController::borrow())
|
| Cyclomatic V(G)     : 5  (E - N + 2 = 13 - 10 + 2 ; P + 1 = 4 + 1 ; Region = 5)
| Independent Path    : 5 jalur (P1..P5) -> 1 Path = 1 test()
|
| Pemetaan node (lihat Borrowing::evaluasiPeminjaman()):
|   1   start
|   2   if !tersedia
|   3   return 'tidak_tersedia'
|   4   if sudahPinjam
|   5   return 'sudah_meminjam'
|   6a  if durasi < 1            -> bagian pertama predikat majemuk (||)
|   6b  if durasi > 30           -> bagian kedua predikat majemuk (||)
|   7   return 'durasi_invalid'
|   8   return 'berhasil'
|
| Predikat (P=4)   : node 2, 4, 6a, 6b  (|| dihitung sebagai 2 node keputusan)
| Daftar edge (E=13):
|   1->2, 2->3, 2->4, 3->exit, 4->5, 4->6a, 5->exit,
|   6a->7, 6a->6b, 6b->7, 6b->8, 7->exit, 8->exit
*/

// ---------------------------------------------------------------------------
// PATH 1 : 1-2-3  (buku tidak tersedia)
// ---------------------------------------------------------------------------
test('Path 1 - buku tidak tersedia ditolak', function () {
    expect(Borrowing::evaluasiPeminjaman(tersedia: false, sudahPinjam: false, durasi: 7))
        ->toBe('tidak_tersedia');
});

// ---------------------------------------------------------------------------
// PATH 2 : 1-2-4-5  (tersedia, tetapi user sudah meminjam buku yang sama)
// ---------------------------------------------------------------------------
test('Path 2 - user sudah meminjam buku yang sama ditolak', function () {
    expect(Borrowing::evaluasiPeminjaman(tersedia: true, sudahPinjam: true, durasi: 7))
        ->toBe('sudah_meminjam');
});

// ---------------------------------------------------------------------------
// PATH 3 : 1-2-4-6a-7  (durasi < 1 -> cabang pertama || bernilai true)
// ---------------------------------------------------------------------------
test('Path 3 - durasi kurang dari 1 ditolak', function () {
    expect(Borrowing::evaluasiPeminjaman(tersedia: true, sudahPinjam: false, durasi: 0))
        ->toBe('durasi_invalid');
});

// ---------------------------------------------------------------------------
// PATH 4 : 1-2-4-6a-6b-7  (durasi > 30 -> cabang kedua || bernilai true)
// ---------------------------------------------------------------------------
test('Path 4 - durasi lebih dari 30 ditolak', function () {
    expect(Borrowing::evaluasiPeminjaman(tersedia: true, sudahPinjam: false, durasi: 31))
        ->toBe('durasi_invalid');
});

// ---------------------------------------------------------------------------
// PATH 5 : 1-2-4-6a-6b-8  (semua guard lolos -> peminjaman berhasil)
// ---------------------------------------------------------------------------
test('Path 5 - semua syarat terpenuhi peminjaman berhasil', function () {
    expect(Borrowing::evaluasiPeminjaman(tersedia: true, sudahPinjam: false, durasi: 7))
        ->toBe('berhasil');
});
