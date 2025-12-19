<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-1227-01-3',
                'description' => 'Novel pertama dari tetralogi Laskar Pelangi, menceritakan kisah 10 anak dari keluarga miskin yang bersekolah di SD Muhammadiyah di Belitung.',
                'stock' => 5,
                'category' => 'Novel',
                'published_year' => 2005,
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '978-979-9023-00-1',
                'description' => 'Novel pertama dari Tetralogi Buru yang mengisahkan kehidupan Minke, seorang priayi Jawa di era kolonial Belanda.',
                'stock' => 3,
                'category' => 'Novel',
                'published_year' => 1980,
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '978-602-291-596-7',
                'description' => 'Buku tentang filosofi Stoa yang membahas cara menjalani hidup dengan bijaksana.',
                'stock' => 4,
                'category' => 'Self-Help',
                'published_year' => 2018,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0-7352-1131-3',
                'description' => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'stock' => 6,
                'category' => 'Self-Help',
                'published_year' => 2018,
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'description' => 'Buku panduan untuk menulis kode yang bersih, mudah dibaca, dan mudah dipelihara.',
                'stock' => 2,
                'category' => 'Teknologi',
                'published_year' => 2008,
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas & Andrew Hunt',
                'isbn' => '978-0-13-595705-9',
                'description' => 'Buku klasik yang membahas prinsip-prinsip dan praktik terbaik dalam pengembangan perangkat lunak.',
                'stock' => 3,
                'category' => 'Teknologi',
                'published_year' => 2019,
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'isbn' => '978-979-461-872-5',
                'description' => 'Buku yang membahas sejarah Indonesia dari periode pra-kolonial hingga era modern.',
                'stock' => 4,
                'category' => 'Sejarah',
                'published_year' => 2005,
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'description' => 'Buku yang menceritakan sejarah singkat umat manusia dari zaman purba hingga modern.',
                'stock' => 5,
                'category' => 'Sejarah',
                'published_year' => 2014,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
