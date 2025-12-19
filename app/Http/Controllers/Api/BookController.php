<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $perPage = $request->get('per_page', 15);
        $books = $query->latest()->paginate($perPage);

        $books->getCollection()->transform(function ($book) {
            $book->available_stock = $book->availableStock();
            $book->is_available = $book->isAvailable();
            return $book;
        });

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function show(Book $book)
    {
        $book->available_stock = $book->availableStock();
        $book->is_available = $book->isAvailable();

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }
}
