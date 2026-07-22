# Task 6: Penyesuaian Stok Opname (`stock_adjustments`) & Approval

## 1. Deskripsi Task
Mengimplementasikan modul Penyesuaian Stok / Stock Opname (`stock_adjustments`) untuk mencatat dan merekonsiliasi selisih antara jumlah barang fisik di lapangan dengan stok sistem.

## 2. Struktur Tabel Database (`stock_adjustments`)
- `id` (PK)
- `adjustment_code` (string, unique, format: `ADJ-YYYYMMDD-XXXX`)
- `product_id` (FK -> products.id)
- `warehouse_id` (FK -> warehouses.id)
- `user_id` (FK -> users.id, pembuat draft opname)
- `approved_by_user_id` (FK -> users.id, nullable, manajer penyetujui)
- `system_quantity` (integer)
- `actual_quantity` (integer)
- `difference` (integer)
- `type` (enum: 'ADDITION', 'SUBTRACTION')
- `reason` (string: Rusak, Hilang, Penyesuaian Audit)
- `status` (enum: 'PENDING', 'APPROVED', 'REJECTED')
- `timestamps`

## 3. Data Dummy & Seeder
- `StockAdjustmentSeeder.php`: Memuat contoh pengajuan stok opname status `APPROVED` dan `PENDING` untuk kebutuhan simulasi approval role Warehouse Manager.

## 4. Alur Bisnis & Authorization Rules
- Staff Gudang dapat menginput draft opname (`PENDING`).
- Hanya pengguna dengan role `Warehouse Manager` atau `Superadmin` yang dapat menekan tombol **Approve** / **Reject**.
- Saat di-approve: stok produk baru diperbarui dan dicatat ke `stock_logs` (Type: `ADJUSTMENT`).
