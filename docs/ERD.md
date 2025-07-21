# Entity Relationship Diagram (ERD) - Sistem Informasi Penjualan Mbetaro

Diagram ini merepresentasikan struktur database sistem penjualan yang digunakan dalam aplikasi **Mbetaro**. Database ini terdiri dari 12 tabel yang saling berelasi untuk menangani proses penjualan, pengembalian, stok ukuran, dan manajemen pengguna.

---

## 📋 Tabel & Penjelasan

### 1. `users`
Menyimpan data pengguna sistem (admin, kasir, user).
- `id` : Primary Key
- `username`, `password`, `email` : Informasi akun
- `role` : enum(`admin`, `kasir`, `user`)
- `created_at` : Tanggal pembuatan akun

### 2. `customers`
Data pelanggan yang melakukan pemesanan.
- `id` : Primary Key
- `user_id` : Relasi ke `users`
- `name`, `phone`, `address` : Identitas pelanggan
- `created_at` : Waktu dibuat

### 3. `categories`
Kategori produk, seperti atasan, bawahan, dll.
- `id` : Primary Key
- `name` : Nama kategori
- `created_at` : Waktu dibuat

### 4. `suppliers`
Data pemasok produk.
- `id` : Primary Key
- `name`, `phone`, `address` : Informasi pemasok
- `created_at` : Waktu dibuat

### 5. `products`
Daftar produk yang dijual.
- `id` : Primary Key
- `category_id` : Relasi ke `categories`
- `supplier_id` : Relasi ke `suppliers`
- `name`, `description`, `price`, `stock`
- `created_at` : Waktu dibuat

### 6. `product_sizes`
Stok berdasarkan ukuran (S, M, L, XL).
- `id` : Primary Key
- `product_id` : Relasi ke `products`
- `size` : enum(S, M, L, XL)
- `stock` : Jumlah stok ukuran tersebut

### 7. `orders`
Transaksi pemesanan oleh pelanggan.
- `id` : Primary Key
- `customer_id` : Relasi ke `customers`
- `user_id` : Relasi ke `users` (kasir/admin)
- `order_date`, `status`, `total` : Detail pesanan

### 8. `order_items`
Item produk di dalam setiap `orders`.
- `id` : Primary Key
- `order_id` : Relasi ke `orders`
- `product_id` : Relasi ke `products`
- `size` : enum(S, M, L, XL)
- `quantity`, `price` : Detail item

### 9. `returns`
Pengembalian barang dari pelanggan.
- `id` : Primary Key
- `order_id` : Relasi ke `orders`
- `product_id` : Relasi ke `products`
- `quantity`, `reason`, `return_date` : Detail retur

### 10. `activity_logs`
Pencatatan aktivitas user di sistem.
- `id` : Primary Key
- `user_id` : Relasi ke `users`
- `activity` : Deskripsi aktivitas
- `created_at` : Timestamp aktivitas

### 11. `settings`
Konfigurasi situs/aplikasi.
- `id` : Primary Key
- `site_name`, `logo_path`
- `created_at` : Timestamp konfigurasi

---

## 🔗 Relasi Antar Tabel

- `users` ➝ `customers`, `orders`, `activity_logs`
- `customers` ➝ `orders`
- `orders` ➝ `order_items`, `returns`
- `products` ➝ `order_items`, `returns`, `product_sizes`
- `categories` ➝ `products`
- `suppliers` ➝ `products`

---

## 🧩 Catatan

- Setiap entitas menggunakan primary key `id` berbentuk integer auto-increment.
- Relasi antar entitas didesain menggunakan foreign key untuk menjaga integritas data.
- Pendekatan enum (`size`, `status`, `role`) digunakan untuk efisiensi dan validasi nilai.

---

**Diagram ini dibuat menggunakan**: [dbdiagram.io](https://dbdiagram.io)  
**Nama Proyek**: `mbetaro`
