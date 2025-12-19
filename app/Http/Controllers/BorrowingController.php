<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = auth()->user()->borrowings()->with('book')->latest()->paginate(10);
        return view('user.borrowings.index', compact('borrowings'));
    }

    public function borrow(Book $book)
    {
        if (!$book->isAvailable()) {
            return back()->with('error', 'Maaf, buku ini sedang tidak tersedia.');
        }

        $existingBorrowing = Borrowing::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14),
            'status' => 'borrowed',
        ]);

        return redirect()->route('user.borrowings.index')->with('success', 'Buku berhasil dipinjam! Harap kembalikan sebelum ' . Carbon::now()->addDays(14)->format('d M Y'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== auth()->id()) {
            abort(403);
        }

        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $borrowing->update([
            'returned_at' => Carbon::now(),
            'status' => 'returned',
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }

    public function dashboard()
    {
        $activeBorrowings = auth()->user()->borrowings()->where('status', 'borrowed')->with('book')->get();
        $returnedCount = auth()->user()->borrowings()->where('status', 'returned')->count();
        $recentBooks = Book::latest()->take(6)->get();

        return view('user.dashboard', compact('activeBorrowings', 'returnedCount', 'recentBooks'));
    }
}
