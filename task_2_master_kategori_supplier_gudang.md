# Task 2: Master Data Kategori, Supplier, & Gudang

## 1. Deskripsi Task
Mengimplementasikan modul Master Data pendukung inventaris yang terdiri dari:
1. Master Kategori (`categories`)
2. Master Pemasok / Vendor (`suppliers`)
3. Master Gudang / Lokasi Penyimpanan (`warehouses`)

Setiap modul dilengkapi dengan Migration, Model, Controller, View Blade (Index, Create, Edit, Show), serta Seeder data dummy.

## 2. Struktur Tabel Database

### A. Tabel `categories`
- `id` (PK)
- `code` (string, unique)
- `name` (string)
- `description` (text, nullable)
- `timestamps`

### B. Tabel `suppliers`
- `id` (PK)
- `code` (string, unique)
- `name` (string)
- `email` (string, nullable)
- `phone` (string, nullable)
- `address` (text, nullable)
- `timestamps`

### C. Tabel `warehouses`
- `id` (PK)
- `code` (string, unique)
- `name` (string)
- `address` (text, nullable)
- `manager_name` (string, nullable)
- `timestamps`

## 3. Data Dummy & Seeder
- `CategorySeeder.php`: Minimal 5 data dummy kategori (Elektronik, Bahan Baku, Alat Tulis Kantor, Suku Cadang, Packaging).
- `SupplierSeeder.php`: Minimal 3 data dummy supplier (PT Indologistic Vendor, CV Terang Abadi, PT Mitra Jaya).
- `WarehouseSeeder.php`: Minimal 3 data dummy gudang (Gudang Utama A, Gudang Transit B, Rak Penyimpanan C1).

## 4. Komponen Berkas Terkait
- **Migrations**: `create_categories_table`, `create_suppliers_table`, `create_warehouses_table`.
- **Controllers**: `CategoryController`, `SupplierController`, `WarehouseController`.
- **Views**: `resources/views/category/*`, `resources/views/supplier/*`, `resources/views/warehouse/*`.
- **Routes**: Web routes CRUD terlindungi otentikasi.
