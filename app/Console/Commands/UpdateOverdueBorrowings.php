<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOverdueBorrowings extends Command
{
    protected $signature = 'borrowings:update-overdue';

    protected $description = 'Update overdue status for borrowings that are past their due date';

    public function handle()
    {
        $overdueBorrowings = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->get();

        $count = 0;
        foreach ($overdueBorrowings as $borrowing) {
            $borrowing->update([
                'status' => 'overdue',
            ]);
            $count++;
        }

        $this->info("Updated {$count} overdue borrowing(s).");
        
        return Command::SUCCESS;
    }
}
