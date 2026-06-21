<?php

namespace App\Models;

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
}
