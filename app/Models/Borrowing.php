<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
        'fine_paid',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->due_date->isPast();
    }

    public function getOverdueDays(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return $this->due_date->diffInDays(now());
    }

    public function calculateFine(int $finePerDay = 1000): float
    {
        $overdueDays = $this->getOverdueDays();

        if ($this->status === 'returned' && $this->returned_at && $this->returned_at->isAfter($this->due_date)) {
            $overdueDays = $this->due_date->diffInDays($this->returned_at);
        }

        return $overdueDays * $finePerDay;
    }

    /**
     * Versi terstruktur (di-instrumentasi) dari logika penghitungan denda
     * keterlambatan yang dipakai sebagai studi kasus White Box Testing
     * (Basis Path Testing) pada laporan Tugas Besar.
     *
     * Invariant: status 'returned' selalu memiliki returned_at (di-set oleh
     * BorrowingController::returnBook()), sehingga node keputusan internal
     * cukup mengevaluasi satu predikat sederhana.
     *
     * Flow graph & Cyclomatic Complexity V(G)=6 didokumentasikan di
     * LAPORAN_PENGUJIAN.md dan diuji oleh tests/Unit/OverdueCheckTest.php.
     */
    public function hitungDenda(int $finePerDay = 1000): float
    {
        $overdueDays = 0;                                              // Node 1

        if ($this->status === 'returned') {                           // Node 2
            if ($this->returned_at->isAfter($this->due_date)) {       // Node 3
                $overdueDays = (int) $this->due_date->diffInDays($this->returned_at); // Node 4
            }
        } elseif ($this->status === 'borrowed') {                     // Node 5
            if ($this->due_date->isPast()) {                          // Node 6
                $overdueDays = (int) $this->due_date->diffInDays(now()); // Node 7
            }
        }

        if ($overdueDays > 0) {                                       // Node 8
            return $overdueDays * $finePerDay;                        // Node 9
        }

        return 0;                                                     // Node 10
    }

    /**
     * Versi terstruktur (di-instrumentasi) dari guard pengajuan peminjaman
     * pada BorrowingController::borrow(). Dipakai sebagai studi kasus White Box
     * Testing (Basis Path) dengan predikat MAJEMUK (durasi < 1 || durasi > 30).
     *
     * Mengembalikan kode hasil evaluasi:
     *   'tidak_tersedia' | 'sudah_meminjam' | 'durasi_invalid' | 'berhasil'
     *
     * Flow graph & V(G)=5 didokumentasikan di LAPORAN_PENGUJIAN.md dan diuji
     * oleh tests/Unit/BorrowEvaluationTest.php.
     */
    public static function evaluasiPeminjaman(bool $tersedia, bool $sudahPinjam, int $durasi): string
    {
        if (! $tersedia) {                              // Node 2
            return 'tidak_tersedia';                    // Node 3
        }

        if ($sudahPinjam) {                             // Node 4
            return 'sudah_meminjam';                    // Node 5
        }

        if ($durasi < 1 || $durasi > 30) {              // Node 6a (<1) & 6b (>30)
            return 'durasi_invalid';                    // Node 7
        }

        return 'berhasil';                              // Node 8
    }

    /**
     * Versi terstruktur (di-instrumentasi) dari logika perulangan pada
     * App\Console\Commands\UpdateOverdueBorrowings::handle(). Dipakai sebagai
     * studi kasus White Box Testing (Basis Path) yang MEMUAT LOOP (foreach).
     *
     * Menerima daftar peminjaman (array assoc: 'id' & 'due_date') lalu
     * mengembalikan daftar id yang sudah melewati batas waktu ($today).
     *
     * Flow graph & V(G)=3 didokumentasikan di LAPORAN_PENGUJIAN.md dan diuji
     * oleh tests/Unit/OverdueLoopTest.php.
     */
    public static function tandaiOverdue(array $items, Carbon $today): array
    {
        $ditandai = [];                                 // Node 1

        foreach ($items as $item) {                     // Node 2 (loop)
            $dueDate = Carbon::parse($item['due_date']);

            if ($dueDate->lessThan($today)) {           // Node 3
                $ditandai[] = $item['id'];              // Node 4
            }
        }

        return $ditandai;                               // Node 5
    }
}
