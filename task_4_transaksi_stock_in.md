# Task 4: Transaksi Penerimaan Barang Masuk (`stock_in_headers` & `stock_in_details`)

## 1. Deskripsi Task
Mengimplementasikan modul Transaksi Barang Masuk (*Stock In Inbound*) dari supplier. Transaksi ini akan secara otomatis menambah `stock_quantity` pada produk yang bersangkutan dan merekam catatan ke `stock_logs`.

## 2. Struktur Tabel Database

### A. Tabel `stock_in_headers`
- `id` (PK)
- `transaction_code` (string, unique, format: `TRX-IN-YYYYMMDD-XXXX`)
- `transaction_date` (date)
- `supplier_id` (FK -> suppliers.id)
- `user_id` (FK -> users.id)
- `total_amount` (decimal 15,2)
- `notes` (text, nullable)
- `timestamps`

### B. Tabel `stock_in_details`
- `id` (PK)
- `stock_in_header_id` (FK -> stock_in_headers.id)
- `product_id` (FK -> products.id)
- `quantity` (integer)
- `unit_price` (decimal 15,2)
- `subtotal` (decimal 15,2)
- `timestamps`

## 3. Data Dummy & Seeder
- `StockInSeeder.php`: Memuat contoh transaksi barang masuk beserta rincian item detailnya dan penyesuaian stok terkait.

## 4. Logika Bisnis & Transaksi Database
- Menggunakan `DB::transaction()` untuk menjamin integritas simpan data header & detail.
- Update otomatis stok produk: `$product->increment('stock_quantity', $qty)`.
- Replikasi log otomatis ke `stock_logs` (Type: `IN`).
