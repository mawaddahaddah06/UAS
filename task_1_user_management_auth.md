# Task 1: Autentikasi & Manajemen Pengguna (User Management & Role Adjustment)

## 1. Deskripsi Task
Menyesuaikan sistem autentikasi dan modul Manajemen Pengguna (*User Management*) yang sudah ada pada proyek Laravel agar selaras dengan **PRD.md**, khususnya dukungan untuk 4 peran (*roles*):
1. **Superadmin**
2. **Warehouse Manager**
3. **Staff Gudang**
4. **Auditor**

## 2. Tujuan & Indikator Keberhasilan
- Tabel `users` diperbarui untuk mendukung kolom `role` (enum / string) dengan validator 4 role di atas serta penambahan kolom `phone` bila belum ada.
- `UserSeeder.php` diperbarui untuk membuat data dummy pengguna untuk setiap role lengkap dengan password standar (`password`) agar visualisasi data pengguna di halaman index dapat diuji.
- `UserController.php` diperbarui pada fungsi `store`, `update`, `index`, `create`, `edit`, `show` agar konsisten mengenali opsi 4 role baru.
- Halaman View (`user/index.blade.php`, `user/create.blade.php`, `user/edit.blade.php`, `user/show.blade.php`) disesuaikan untuk menampilkan badge dan dropdown role secara presisi sesuai UI NiceAdmin.

## 3. Spesifikasi Teknis & Komponen Terkait

### A. Migration (`database/migrations/0001_01_01_000000_create_users_table.php` atau migration penyesuaian)
- Memastikan kolom `role` menyimpan nilai: `'Superadmin'`, `'Warehouse Manager'`, `'Staff Gudang'`, `'Auditor'`.
- Memastikan kolom `phone` dan `avatar` tersedia.

### B. Seeder (`database/seeders/UserSeeder.php`)
Menyediakan data dummy lengkap untuk keempat role:
1. `tamus@gmail.com` -> Role: `Superadmin`
2. `manager@gmail.com` -> Role: `Warehouse Manager`
3. `staff@gmail.com` -> Role: `Staff Gudang`
4. `auditor@gmail.com` -> Role: `Auditor`

### C. Controller (`app/Http/Controllers/UserController.php`)
- Menyesuaikan aturan validasi pada `store()` dan `update()`:
  `'role' => 'required|in:Superadmin,Warehouse Manager,Staff Gudang,Auditor'`
- Menggunakan skema transaksi `DB::beginTransaction()` dan `DB::commit()` konsisten dengan kode yang ada.
- Penanganan upload avatar via `Storage::disk('public')`.

### D. Views (`resources/views/user/*.blade.php`)
- Opsi elemen `<select name="role">` pada `create.blade.php` dan `edit.blade.php` di-update untuk menyertakan 4 pilihan role.
- Badge role pada `index.blade.php` menggunakan warna Bootstrap yang membedakan masing-masing role:
  - Superadmin: `bg-danger`
  - Warehouse Manager: `bg-primary`
  - Staff Gudang: `bg-info`
  - Auditor: `bg-secondary`

## 4. Pengujian & Data Dummy (Verification Plan)
1. Menjalankan `php artisan db:seed --class=UserSeeder`
2. Mengakses `/user` dan menguji CRUD untuk masing-masing role.
