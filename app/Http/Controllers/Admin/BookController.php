<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:1',
            'category' => 'nullable|string|max:100',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        $borrowings = $book->borrowings()->with('user')->latest()->paginate(10);
        return view('admin.books.show', compact('book', 'borrowings'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:1',
            'category' => 'nullable|string|max:100',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalBorrowings = Borrowing::where('status', 'borrowed')->count();
        $totalReturned = Borrowing::where('status', 'returned')->count();
        $recentBorrowings = Borrowing::with(['user', 'book'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBooks', 'totalBorrowings', 'totalReturned', 'recentBorrowings'));
    }

    public function borrowings()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->paginate(15);
        return view('admin.borrowings.index', compact('borrowings'));
    }
}
