# Task 3: Master Data Produk / Barang (`products`)

## 1. Deskripsi Task
Mengimplementasikan modul Master Data Produk/Barang yang mengintegrasikan relasi ke `categories` dan `warehouses`.

## 2. Struktur Tabel Database (`products`)
- `id` (PK)
- `category_id` (FK -> categories.id)
- `warehouse_id` (FK -> warehouses.id)
- `sku` (string, unique)
- `name` (string)
- `unit` (string: Pcs, Box, Roll, Unit)
- `purchase_price` (decimal 15,2)
- `selling_price` (decimal 15,2)
- `stock_quantity` (integer, default 0)
- `min_stock` (integer, default 5)
- `description` (text, nullable)
- `timestamps`

## 3. Data Dummy & Seeder
- `ProductSeeder.php`: Memuat minimal 10 data barang dummy dengan variasi stok normal dan stok di bawah `min_stock` untuk memicu indikator alert stok minimum di dashboard UI.

## 4. Fitur Utama & Logika
- CRUD Barang lengkap dengan form modal / page Blade NiceAdmin.
- Validasi SKU unik.
- Indikator badge status stok (Stok Aman: Hijau, Menipis / Min Stock: Kuning/Merah).
- Relasi Eloquent `belongsTo` ke `Category` dan `Warehouse`.
