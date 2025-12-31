# 📚 Sistem Denda Perpustakaan Digital

## 🎯 Overview
Sistem denda otomatis untuk user yang terlambat mengembalikan buku pinjaman.

## 💰 Konfigurasi Denda
- **Denda per hari**: Rp 1.000 (default)
- **Masa pinjam**: 14 hari
- **Status**: Unpaid / Paid

## 📊 Struktur Database

### Kolom Baru di Tabel `borrowings`
```sql
fine_amount DECIMAL(10,2) DEFAULT 0    -- Total denda
fine_paid BOOLEAN DEFAULT false        -- Status pembayaran denda
```

## 🔄 Alur Kerja Sistem

### 1. **Peminjaman Buku**
- User meminjam buku
- `due_date` otomatis di-set 14 hari dari tanggal pinjam
- `status` = 'borrowed'
- `fine_amount` = 0

### 2. **Pengembalian Buku**
```php
// Sistem otomatis menghitung denda saat pengembalian
$fineAmount = $borrowing->calculateFine(); // Rp 1.000 x hari terlambat

// Update database
$borrowing->update([
    'returned_at' => Carbon::now(),
    'status' => 'returned',
    'fine_amount' => $fineAmount,
]);
```

### 3. **Auto-Update Status Overdue**
Command otomatis dijalankan setiap hari untuk mengupdate status:
```bash
php artisan borrowings:update-overdue
```

**Scheduled Task** (routes/console.php):
```php
Schedule::command('borrowings:update-overdue')->daily();
```

## 📝 Method di Model Borrowing

### `isOverdue()`
Mengecek apakah peminjaman terlambat:
```php
public function isOverdue(): bool
{
    return $this->status === 'borrowed' && $this->due_date->isPast();
}
```

### `getOverdueDays()`
Menghitung jumlah hari terlambat:
```php
public function getOverdueDays(): int
{
    if (!$this->isOverdue()) {
        return 0;
    }
    return $this->due_date->diffInDays(now());
}
```

### `calculateFine($finePerDay = 1000)`
Menghitung total denda:
```php
public function calculateFine(int $finePerDay = 1000): float
{
    $overdueDays = $this->getOverdueDays();
    
    // Jika sudah dikembalikan tapi terlambat
    if ($this->status === 'returned' && $this->returned_at && $this->returned_at->isAfter($this->due_date)) {
        $overdueDays = $this->due_date->diffInDays($this->returned_at);
    }
    
    return $overdueDays * $finePerDay;
}
```

## 🎨 Tampilan UI

### Tabel Peminjaman
| Kolom | Keterangan |
|-------|-----------|
| Fine  | Menampilkan total denda |
| Status Fine | Paid (hijau) / Unpaid (merah) |

### Visual Indikator
- ⏰ **Borrowed** (kuning) - Peminjaman aktif
- 🚨 **Late!** (merah + animasi pulse) - Terlambat
- ✅ **Returned** (hijau) - Sudah dikembalikan

### Perhitungan Real-time
```blade
@if($borrowing->status === 'borrowed' && $borrowing->due_date->isPast())
    <span class="text-yellow-400">
        Rp {{ number_format($borrowing->calculateFine(), 0, ',', '.') }}
    </span>
@endif
```

## 🔧 Cara Mengubah Tarif Denda

### Opsi 1: Edit Controller
```php
// BorrowingController.php & Api/BorrowingController.php
$fineAmount = $borrowing->calculateFine(2000); // Ubah dari 1000 ke 2000
```

### Opsi 2: Tambah Config
```php
// config/library.php (buat file baru)
return [
    'fine_per_day' => env('LIBRARY_FINE_PER_DAY', 1000),
    'loan_duration_days' => env('LIBRARY_LOAN_DURATION', 14),
];

// Kemudian gunakan:
$fineAmount = $borrowing->calculateFine(config('library.fine_per_day'));
```

## 🚀 Testing

### Manual Test Command
```bash
# Update status overdue
php artisan borrowings:update-overdue

# Lihat hasil
php artisan tinker
>>> Borrowing::where('status', 'overdue')->count()
```

### Test Scenario
1. Pinjam buku
2. Ubah `due_date` ke tanggal kemarin (via database)
3. Jalankan command update-overdue
4. Kembalikan buku
5. Cek apakah denda ter-calculate dengan benar

## ⚙️ Setup Cron Job (Production)

Untuk menjalankan scheduled task di production:

```bash
# Edit crontab
crontab -e

# Tambahkan:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 📌 Catatan Penting

1. **Status 'overdue'** hanya di-update via command, bukan otomatis
2. **Denda** dihitung saat pengembalian buku
3. **fine_paid** belum ada fitur pembayaran (perlu implementasi payment gateway)
4. **Real-time calculation** ditampilkan di UI untuk buku yang masih dipinjam dan terlambat

## 🔮 Fitur yang Bisa Ditambahkan

- [ ] Payment Gateway untuk pembayaran denda
- [ ] Email reminder sebelum due date
- [ ] Push notification untuk peminjaman yang mendekati deadline
- [ ] Dashboard admin untuk tracking denda yang belum dibayar
- [ ] Laporan keuangan denda
- [ ] Blokir peminjaman baru jika ada denda yang belum dibayar
- [ ] History pembayaran denda
- [ ] Diskon/Waive denda oleh admin
