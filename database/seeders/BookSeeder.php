<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan direktori books ada
        if (!Storage::disk('public')->exists('books')) {
            Storage::disk('public')->makeDirectory('books');
        }

        // 2. Setup Context untuk Download (Bypass 403 Forbidden)
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n",
                'timeout' => 15
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-1227-01-3',
                'description' => 'Novel pertama dari tetralogi Laskar Pelangi.',
                'stock' => 5,
                'category' => 'Novel',
                'published_year' => 2005,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/id/8/8e/Laskar_pelangi_sampul.jpg',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '978-979-9023-00-1',
                'description' => 'Novel pertama dari Tetralogi Buru.',
                'stock' => 3,
                'category' => 'Novel',
                'published_year' => 1980,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/id/thumb/4/4c/Bumi_Manusia.jpg/220px-Bumi_Manusia.jpg',
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '978-602-291-596-7',
                'description' => 'Buku tentang filosofi Stoa.',
                'stock' => 4,
                'category' => 'Self-Help',
                'published_year' => 2018,
                'image_url' => 'https://cdn.gramedia.com/uploads/items/9786022915967_Filosofi_Teras_C_1_4.jpg',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0-7352-1131-3',
                'description' => 'Panduan praktis untuk membangun kebiasaan baik.',
                'stock' => 6,
                'category' => 'Self-Help',
                'published_year' => 2018,
                'image_url' => 'https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'description' => 'Buku panduan untuk menulis kode yang bersih.',
                'stock' => 2,
                'category' => 'Teknologi',
                'published_year' => 2008,
                'image_url' => 'https://images-na.ssl-images-amazon.com/images/I/41jEbK-jG+L._SX374_BO1,204,203,200_.jpg',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas & Andrew Hunt',
                'isbn' => '978-0-13-595705-9',
                'description' => 'Buku klasik pengembangan perangkat lunak.',
                'stock' => 3,
                'category' => 'Teknologi',
                'published_year' => 2019,
                'image_url' => 'https://images-na.ssl-images-amazon.com/images/I/41as+WafrFL._SX396_BO1,204,203,200_.jpg',
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'isbn' => '978-979-461-872-5',
                'description' => 'Buku sejarah Indonesia.',
                'stock' => 4,
                'category' => 'Sejarah',
                'published_year' => 2005,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/id/0/03/Sejarah_Indonesia_Modern_1200-2004.jpg',
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'description' => 'Sejarah singkat umat manusia.',
                'stock' => 5,
                'category' => 'Sejarah',
                'published_year' => 2014,
                'image_url' => 'https://images-na.ssl-images-amazon.com/images/I/41yu2qXhXXL._SX324_BO1,204,203,200_.jpg',
            ],
        ];

        foreach ($books as $data) {
            $imageUrl = $data['image_url'];
            unset($data['image_url']);
            
            $filename = 'books/' . Str::slug($data['title']) . '-' . time() . '.jpg';
            $saved = false;

            // Percobaan 1: Download URL Utama
            try {
                $content = @file_get_contents($imageUrl, false, $context);
                if ($content && strlen($content) > 1000) {
                    Storage::disk('public')->put($filename, $content);
                    $data['cover_image'] = $filename;
                    $saved = true;
                }
            } catch (\Exception $e) {}

            // Percobaan 2: Fallback ke UI Avatars (Placeholder Pasti)
            if (!$saved) {
                try {
                    $fallbackUrl = "https://ui-avatars.com/api/?name=" . urlencode($data['title']) . "&background=0D8ABC&color=fff&size=512&font-size=0.33&length=2";
                    $content = @file_get_contents($fallbackUrl, false, $context);
                    if ($content) {
                        Storage::disk('public')->put($filename, $content);
                        $data['cover_image'] = $filename;
                        $saved = true;
                    }
                } catch (\Exception $e) {}
            }

            Book::create($data);
        }
    }
}
