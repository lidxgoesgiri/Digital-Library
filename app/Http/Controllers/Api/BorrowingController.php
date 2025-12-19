<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->borrowings()->with('book');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 15);
        $borrowings = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $borrowings
        ]);
    }

    public function borrow(Request $request, Book $book)
    {
        if (!$book->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, buku ini sedang tidak tersedia.'
            ], 400);
        }

        $existingBorrowing = Borrowing::where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya.'
            ], 400);
        }

        $borrowing = Borrowing::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14),
            'status' => 'borrowed',
        ]);

        $borrowing->load('book');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dipinjam! Harap kembalikan sebelum ' . Carbon::now()->addDays(14)->format('d M Y'),
            'data' => $borrowing
        ], 201);
    }

    public function returnBook(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.'
            ], 403);
        }

        if ($borrowing->status === 'returned') {
            return response()->json([
                'success' => false,
                'message' => 'Buku ini sudah dikembalikan.'
            ], 400);
        }

        $borrowing->update([
            'returned_at' => Carbon::now(),
            'status' => 'returned',
        ]);

        $borrowing->load('book');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan!',
            'data' => $borrowing
        ]);
    }
}
