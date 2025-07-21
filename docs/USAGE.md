# 🛍️ Panduan Penggunaan Aplikasi MbetaRO

Dokumen ini menjelaskan cara menggunakan aplikasi **MbetaRO** (Mbeta Fashion Retail Online), mulai dari login sebagai admin, kasir, atau pelanggan, hingga mengelola produk, transaksi, dan laporan.

---

## 👤 Peran Pengguna (User Roles)

| Role     | Deskripsi                                                                 |
|----------|--------------------------------------------------------------------------|
| **Admin**  | Mengelola kategori, produk, supplier, pengguna, dan melihat laporan.     |
| **Kasir**  | Melayani pesanan pelanggan, memproses checkout, dan melihat riwayat.     |
| **Pelanggan** | Melihat katalog, memilih produk, melakukan checkout, dan lihat struk. |

---

## 🔐 Login & Registrasi

### Pelanggan
- **Halaman**: `pages/user/register.php` → Daftar akun baru
- **Login**: `pages/user/login.php` → Masuk ke akun
- **Setelah login**: Dialihkan ke dashboard pelanggan (`pages/user/dashboard.php`)

### Admin/Kasir
- **Login**: `pages/user/login.php`
- Login berdasarkan **role** (`admin` / `kasir`) akan diarahkan ke dashboard masing-masing:
  - Admin: `pages/admin/dashboard.php`
  - Kasir: `pages/kasir/dashboard.php`

---

## 🛒 Alur Penggunaan Pelanggan

1. **Lihat Katalog**  
   - `pages/shop/index.php`  
   - Tampilan seperti Shopee, warna soft Instagram.

2. **Lihat Detail Produk**  
   - Klik produk → `pages/shop/detail.php?id=...`

3. **Tambah ke Keranjang**  
   - Tombol "Tambah ke Keranjang" menyimpan ke `$_SESSION['cart']`

4. **Lihat Keranjang**  
   - `pages/shop/keranjang.php`  
   - Bisa ubah jumlah atau hapus produk.

5. **Checkout**  
   - `pages/shop/checkout.php`  
   - Jika belum isi data diri → wajib isi form nama, HP, alamat → simpan ke tabel `customers`.
   - Jika data sudah ada → langsung lanjut checkout → data disimpan ke tabel `orders` & `order_items`.

6. **Lihat Riwayat Pesanan**  
   - `pages/shop/riwayat.php`

7. **Lihat Struk (Invoice)**  
   - Klik detail pesanan di `riwayat.php` → `struk.php`

---

## 🧾 Alur Penggunaan Kasir

1. **Login Sebagai Kasir**
   - Dashboard: `pages/kasir/dashboard.php`

2. **Melihat Pesanan Pelanggan**
   - Menu transaksi: `modules/transactions/index.php`
   - Status awal: `pending`

3. **Proses Checkout**
   - Klik "Proses" → pesanan akan diubah status ke `processed`
   - Struk akan tersedia untuk kasir maupun pelanggan

4. **Lihat Riwayat Transaksi**
   - Semua transaksi yang telah diproses → tampil di `modules/transactions/history.php`

---

## ⚙️ Alur Penggunaan Admin

1. **Dashboard Admin**
   - `pages/admin/dashboard.php`

2. **Manajemen Data:**
   - Kategori: `modules/categories/index.php`
   - Produk: `modules/products/index.php`
   - Supplier: `modules/suppliers/index.php`
   - Pelanggan: `modules/customers/index.php`
   - User: `modules/users/index.php`

3. **Laporan:**
   - Laporan Penjualan: `report/laporan_penjualan.php`
   - Laporan Pengguna: `report/laporan_pengguna.php`
   - Lihat Struk: `report/struk.php`

---

## 🗃️ Struktur Data & Relasi (Database)

### Tabel Utama:
- `users` – data user (admin/kasir/pelanggan)
- `customers` – data pelanggan (nama, no HP, alamat)
- `products` – data produk fashion
- `categories` – kategori produk (blouse, crop, dll)
- `suppliers` – data pemasok
- `orders` – transaksi utama (1 pelanggan bisa punya banyak pesanan)
- `order_items` – item per pesanan (produk + qty + harga + ukuran)
- `returns` – pengembalian barang (opsional)
- `activity_logs` – log aktivitas (opsional)
- `settings` – pengaturan sistem (opsional)

> **Catatan:** Stok per ukuran disimpan menggunakan tabel `product_sizes` (jika kamu aktifkan nanti).

---

## 🖼️ Gambar Produk

- Disimpan di folder: `uploads/`
- Penempatan berdasarkan kategori:
  - `uploads/blouse/`, `uploads/crop/`, dll
- File gambar dipanggil dinamis berdasarkan `category_id`

---

## 📝 Tips

- Pastikan file SQL `mbetaro.sql` sudah di-*import* ke MySQL.
- Gunakan XAMPP/Laragon untuk menjalankan server lokal.
- Jika session logout otomatis, periksa session time & role.

---

📌 Untuk informasi setup lokal, lihat file [docs/INSTALLATION.md](INSTALLATION.md)  
📌 Untuk ringkasan umum, buka [README.md](../README.md)

---