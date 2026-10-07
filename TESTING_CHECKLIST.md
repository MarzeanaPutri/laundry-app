# ✅ Checklist Pengujian Manual — Sistem Manajemen Laundry

> **URL Aplikasi:** `http://localhost/laundry-app/public`  
> **Akun Demo:** admin@laundry.com / kasir@laundry.com / owner@laundry.com (password: `password`)

---

## 1. AUTENTIKASI

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 1.1 | Login berhasil (Admin) | Buka `/login`, isi email admin, klik Masuk | Redirect ke `/dashboard`, sidebar tampil menu lengkap | |
| 1.2 | Login berhasil (Kasir) | Login sebagai kasir | Redirect ke `/dashboard`, menu Admin tersembunyi | |
| 1.3 | Login berhasil (Owner) | Login sebagai owner | Redirect ke `/dashboard`, hanya menu Laporan & Dashboard | |
| 1.4 | Login gagal | Isi password salah | Pesan error "credentials do not match" | |
| 1.5 | Logout | Klik tombol Logout | Redirect ke `/login`, session dihapus | |
| 1.6 | Log login tercatat | Login lalu cek `/logs` (admin) | Muncul entri action=login | |

---

## 2. RBAC — KONTROL AKSES

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 2.1 | Kasir akses `/outlets` | Login kasir, buka `/outlets` | HTTP 403 Akses ditolak | |
| 2.2 | Kasir akses `/users` | Login kasir, buka `/users` | HTTP 403 Akses ditolak | |
| 2.3 | Kasir akses `/logs` | Login kasir, buka `/logs` | HTTP 403 Akses ditolak | |
| 2.4 | Owner akses `/transactions` | Login owner, buka `/transactions` | HTTP 403 Akses ditolak | |
| 2.5 | Owner akses `/reports` | Login owner, buka `/reports` | Halaman laporan tampil (view-only) | |
| 2.6 | Guest akses dashboard | Buka `/dashboard` tanpa login | Redirect ke `/login` | |

---

## 3. MANAJEMEN OUTLET (Admin)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 3.1 | Lihat daftar outlet | Buka `/outlets` | Tabel outlet tampil dengan pagination | |
| 3.2 | Tambah outlet | Klik "+ Tambah Outlet", isi form, simpan | Outlet baru muncul di daftar, flash success | |
| 3.3 | Validasi form outlet | Submit form kosong | Pesan validasi muncul per field | |
| 3.4 | Edit outlet | Klik Edit, ubah nama, simpan | Data terupdate, flash success | |
| 3.5 | Nonaktifkan outlet | Edit outlet, uncheck "Outlet Aktif" | Status berubah jadi Nonaktif | |
| 3.6 | Hapus outlet | Klik Hapus, konfirmasi | Outlet terhapus, log delete tercatat | |

---

## 4. REGISTRASI PELANGGAN (Admin & Kasir)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 4.1 | Tambah pelanggan | Isi form registrasi, simpan | Pelanggan terdaftar, flash success | |
| 4.2 | Duplikat nomor telepon | Daftarkan pelanggan dengan no. HP sama | Pesan error "phone sudah digunakan" | |
| 4.3 | Cari pelanggan | Ketik nama di kolom pencarian | Hasil filter sesuai keyword | |
| 4.4 | Edit pelanggan | Ubah alamat pelanggan | Data terupdate | |
| 4.5 | Hapus pelanggan (Admin) | Login admin, hapus pelanggan | Pelanggan terhapus | |
| 4.6 | Hapus pelanggan (Kasir) | Login kasir, cek tombol Hapus | Tombol Hapus tidak tampil | |

---

## 5. MANAJEMEN PAKET LAUNDRY (Admin)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 5.1 | Lihat daftar paket | Buka `/products` | 6 paket default tampil | |
| 5.2 | Tambah paket kiloan | Isi form, tipe=kiloan, simpan | Paket baru muncul | |
| 5.3 | Tambah paket express | Isi form, tipe=express, simpan | Badge "Express" tampil | |
| 5.4 | Edit harga paket | Ubah harga, simpan | Harga terupdate | |
| 5.5 | Nonaktifkan paket | Uncheck "Paket Aktif" | Status Nonaktif, tidak muncul di form transaksi | |
| 5.6 | Hapus paket | Klik Hapus | Paket terhapus | |

---

## 6. ENTRI TRANSAKSI (Admin & Kasir)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 6.1 | Buat transaksi baru | Pilih pelanggan, outlet, tambah item, simpan | Invoice otomatis terbuat (INV-YYYYMMDD-XXXX) | |
| 6.2 | Tambah multiple item | Klik "+ Tambah Item" beberapa kali | Row baru muncul, total terupdate otomatis | |
| 6.3 | Hapus item row | Klik tombol × pada row | Row terhapus, total recalculate | |
| 6.4 | Kalkulasi otomatis | Pilih paket, ubah jumlah | Subtotal & grand total update real-time | |
| 6.5 | Validasi item kosong | Submit tanpa pilih paket | Pesan validasi muncul | |
| 6.6 | Filter transaksi | Filter by status=proses | Hanya transaksi berstatus proses tampil | |
| 6.7 | Detail transaksi | Klik Detail | Halaman show tampil dengan semua item | |
| 6.8 | Update status ke selesai | Di halaman detail, ubah status=selesai | Status terupdate, log tercatat | |
| 6.9 | Update pembayaran lunas | Ubah payment_status=lunas, isi jumlah bayar | Status pembayaran berubah, field paid_amount muncul | |
| 6.10 | Hapus transaksi (Admin) | Login admin, hapus transaksi | Transaksi terhapus beserta items-nya | |

---

## 7. MANAJEMEN PENGGUNA (Admin)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 7.1 | Lihat daftar user | Buka `/users` | Tabel user dengan badge role | |
| 7.2 | Tambah user kasir | Isi form, role=kasir, simpan | User baru muncul | |
| 7.3 | Validasi email duplikat | Daftarkan email yang sudah ada | Pesan error email sudah digunakan | |
| 7.4 | Edit user (ganti role) | Ubah role kasir → admin | Role terupdate | |
| 7.5 | Reset password user | Edit user, isi password baru | Password berubah | |
| 7.6 | Nonaktifkan user | Uncheck "Akun Aktif" | Status Nonaktif | |
| 7.7 | Hapus user lain | Klik Hapus user lain | User terhapus | |
| 7.8 | Hapus diri sendiri | Klik Hapus pada akun sendiri | Pesan error "tidak dapat menghapus akun sendiri" | |

---

## 8. LAPORAN

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 8.1 | Laporan default | Buka `/reports` | Tampil data bulan berjalan | |
| 8.2 | Filter by tanggal | Set date_from & date_to, klik Tampilkan | Data sesuai rentang tanggal | |
| 8.3 | Filter by outlet | Pilih outlet tertentu | Hanya transaksi outlet tersebut | |
| 8.4 | Filter by status | Pilih status=selesai | Hanya transaksi selesai | |
| 8.5 | Summary cards akurat | Bandingkan total dengan data manual | Angka summary sesuai | |
| 8.6 | Owner akses laporan | Login owner, buka `/reports` | Laporan tampil tanpa error | |

---

## 9. SYSTEM LOG (Admin)

| # | Skenario | Langkah | Ekspektasi | ✓/✗ |
|---|----------|---------|------------|-----|
| 9.1 | Log login tercatat | Login, cek `/logs` | Entri action=login muncul | |
| 9.2 | Log logout tercatat | Logout, login lagi, cek logs | Entri action=logout muncul | |
| 9.3 | Log create tercatat | Tambah pelanggan, cek logs | Entri action=create, model=Customer | |
| 9.4 | Log update tercatat | Edit outlet, cek logs | Entri action=update, model=Outlet | |
| 9.5 | Log delete tercatat | Hapus produk, cek logs | Entri action=delete, model=Product | |
| 9.6 | Filter log by action | Filter action=delete | Hanya log delete tampil | |
| 9.7 | IP address tercatat | Cek kolom IP di log | IP address 127.0.0.1 tercatat | |

---

## 10. UI/UX

| # | Skenario | Ekspektasi | ✓/✗ |
|---|----------|------------|-----|
| 10.1 | Sidebar navigasi | Menu tampil sesuai role masing-masing | |
| 10.2 | Flash message success | Setelah simpan data, pesan hijau muncul | |
| 10.3 | Flash message error | Setelah gagal, pesan merah muncul | |
| 10.4 | Konfirmasi hapus | Dialog konfirmasi muncul sebelum delete | |
| 10.5 | Pagination | Data > 10 item, pagination muncul | |
| 10.6 | Responsive layout | Tampilan baik di layar kecil (mobile) | |
| 10.7 | Active menu highlight | Menu aktif berwarna lebih gelap di sidebar | |

---

## Ringkasan Hasil Pengujian

| Modul | Total | Lulus | Gagal |
|-------|-------|-------|-------|
| Autentikasi | 6 | | |
| RBAC | 6 | | |
| Outlet | 6 | | |
| Pelanggan | 6 | | |
| Produk | 6 | | |
| Transaksi | 10 | | |
| Pengguna | 8 | | |
| Laporan | 6 | | |
| System Log | 7 | | |
| UI/UX | 7 | | |
| **Total** | **68** | | |
