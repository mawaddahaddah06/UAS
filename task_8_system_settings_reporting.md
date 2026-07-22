# Task 8: Pengaturan Sistem (`settings`) & Laporan Dashboard / Export PDF

## 1. Deskripsi Task
Mengimplementasikan modul Pengaturan Sistem (`settings`), Dashboard Eksekutif, dan Laporan Cetak Export PDF untuk kebutuhan manajemen.

## 2. Struktur Tabel Database (`settings`)
- `id` (PK)
- `key` (string, unique)
- `value` (text, nullable)
- `group` (string, default: 'system')
- `description` (string, nullable)
- `timestamps`

## 3. Data Dummy & Seeder
- `SettingSeeder.php`: Memuat konfigurasi default seperti `app_name`, `company_name`, `company_address`, `low_stock_threshold`, `currency_symbol`.

## 4. Tampilan & Fitur Utama
- **Dashboard Ringkasan**:
  - Total Barang & Nilai Total Inventaris (Rp).
  - Widget Peringatan Stok Minimum (*Low Stock Alerts*).
  - Grafik Transaksi Masuk vs Keluar Bulanan.
- **Modul Settings UI**: Form pengeditan konfigurasi sistem untuk Superadmin.
- **Export PDF**: Menggunakan DomPDF untuk mencetak Laporan Inventaris Stok dan Cetak Resi Transaksi.
