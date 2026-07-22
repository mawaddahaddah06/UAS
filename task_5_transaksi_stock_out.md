# Task 5: Transaksi Pengeluaran Barang (`stock_out_headers` & `stock_out_details`)

## 1. Deskripsi Task
Mengimplementasikan modul Transaksi Pengeluaran Barang (*Stock Out Outbound*). Mengurangi jumlah stok produk di sistem secara otomatis dan merekam jejak mutasi barang.

## 2. Struktur Tabel Database

### A. Tabel `stock_out_headers`
- `id` (PK)
- `transaction_code` (string, unique, format: `TRX-OUT-YYYYMMDD-XXXX`)
- `transaction_date` (date)
- `recipient_department` (string)
- `user_id` (FK -> users.id)
- `total_amount` (decimal 15,2)
- `notes` (text, nullable)
- `timestamps`

### B. Tabel `stock_out_details`
- `id` (PK)
- `stock_out_header_id` (FK -> stock_out_headers.id)
- `product_id` (FK -> products.id)
- `quantity` (integer)
- `unit_price` (decimal 15,2)
- `subtotal` (decimal 15,2)
- `timestamps`

## 3. Data Dummy & Seeder
- `StockOutSeeder.php`: Memuat data contoh transaksi barang keluar untuk pengujian dashboard dan kartu stok.

## 4. Logika Bisnis & Validasi Guard
- Menolak transaksi jika stok fisik produk kurang dari jumlah pengeluaran yang diminta (*Anti-Negative Stock Guard*).
- Kurangi stok produk: `$product->decrement('stock_quantity', $qty)`.
- Replikasi log otomatis ke `stock_logs` (Type: `OUT`).
