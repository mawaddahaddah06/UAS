# Task 7: Log Mutasi Stok & Kartu Stok (`stock_logs`)

## 1. Deskripsi Task
Mengimplementasikan modul *Stock Logs* (Audit Trail Mutasi Stok) yang bersifat *append-only* (hanya-baca / tidak dapat diubah atau dihapus) untuk menelusuri seluruh riwayat pergerakan stok produk.

## 2. Struktur Tabel Database (`stock_logs`)
- `id` (PK)
- `product_id` (FK -> products.id)
- `user_id` (FK -> users.id)
- `reference_number` (string)
- `type` (enum: 'IN', 'OUT', 'ADJUSTMENT')
- `quantity_before` (integer)
- `quantity_change` (integer)
- `quantity_after` (integer)
- `notes` (text, nullable)
- `created_at` (timestamp)

## 3. Data Dummy & Seeder
- `StockLogSeeder.php`: Memuat rekam jejak mutasi historis untuk memverifikasi visualisasi tampilan Kartu Stok Produk (*Product Stock Card*).

## 4. Tampilan & Fitur Utama
- **Kartu Stok Produk (Stock Card)**: Filter log berdasarkan produk dan rentang tanggal.
- Menampilkan grafik / tabel kronologis saldo awal, mutasi masuk (+), mutasi keluar (-), dan saldo akhir.
- Tanpa aksi Edit / Delete untuk menjaga kredibilitas data audit.
