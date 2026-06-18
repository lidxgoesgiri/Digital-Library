<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'borrowed_at' => Carbon::now()->subDays(3),
            'due_date' => Carbon::now()->addDays(4),
            'returned_at' => null,
            'status' => 'borrowed',
            'fine_amount' => 0,
            'fine_paid' => false,
        ];
    }

    /**
     * State: peminjaman sudah melewati batas waktu (overdue) namun belum dikembalikan.
     */
    public function overdue(int $daysLate = 3): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'borrowed',
            'borrowed_at' => Carbon::now()->subDays($daysLate + 7),
            'due_date' => Carbon::now()->subDays($daysLate),
            'returned_at' => null,
        ]);
    }

    /**
     * State: peminjaman sudah dikembalikan tepat waktu.
     */
    public function returnedOnTime(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'returned',
            'borrowed_at' => Carbon::now()->subDays(5),
            'due_date' => Carbon::now()->addDays(2),
            'returned_at' => Carbon::now(),
        ]);
    }

    /**
     * State: peminjaman dikembalikan terlambat.
     */
    public function returnedLate(int $daysLate = 4): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'returned',
            'borrowed_at' => Carbon::now()->subDays($daysLate + 5),
            'due_date' => Carbon::now()->subDays($daysLate),
            'returned_at' => Carbon::now(),
        ]);
    }
}
