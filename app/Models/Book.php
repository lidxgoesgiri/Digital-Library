<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'cover_image',
        'stock',
        'category',
        'published_year',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function availableStock(): int
    {
        $borrowed = $this->borrowings()->where('status', 'borrowed')->count();
        return $this->stock - $borrowed;
    }

    public function isAvailable(): bool
    {
        return $this->availableStock() > 0;
    }
}
