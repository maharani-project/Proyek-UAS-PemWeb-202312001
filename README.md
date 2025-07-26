# 🛍️ MbetaRO - Aplikasi Web Toko Fashion Online

MbetaRO adalah aplikasi web dinamis berbasis PHP native dan MySQL untuk mengelola toko fashion online. Proyek ini mendukung fitur multi-role (admin, kasir, pelanggan) dan dirancang dengan tampilan sederhana namun dengan warna soft seperti lavender, peach, dan rose pink.

---

## 🧪 Demo 
 
> [🔗 Tonton Demo di Youtube](https://youtu.be/p_LmHbozZZ4)
> [🔗 Kunjungi Website Demo](mbetaro.my.id)

---

## 📌 Fitur Utama

| Role          | Fitur                                                                 |
|---------------|-----------------------------------------------------------------------|
| **Admin**     | - Manajemen Produk, Kategori, Supplier, Pengguna dan Laporan          |
|               | - Melihat dan mencetak laporan penjualan                              |
|               | - Melihat struk pesanan pelanggan                                     |
| **Kasir**     | - Melihat dan memproses pesanan dari pelanggan                        |
|               | - Melihat riwayat transaksi kasir                                     |
|**Pelanggan**  | - Registrasi dan login                                                |
|               | - Menjelajahi katalog produk                                          |
|               | - Melihat detail produk & pilih ukuran (S, M, L, XL)                  |
|               | - Menambahkan produk ke keranjang                                     |
|               | - Melakukan checkout dan melihat riwayat pesanan                      |

---

## 🗂️ Struktur Folder

```text
mbetaro/
│
├── assets/ # File CSS, JS, banner, Video, gambar statis
│   ├── banner
│   ├── css
│   ├── img
│   ├── js
│   └── video
│
├── config/ # File konfigurasi 
│   └── db.php
│
├── docs/ 
│   ├── cetak laporan penjualan.pdf
│   ├── INSTALLATION.md
│   ├── MbetaRO_struk(Admin).pdf
│   ├── mbetaro.dbml.png
│   └── mbetaro.dbml.pdf
│
├── includes/ # Header, footer, auth
│ ├── auth.php
│ ├── footer.php
│ └── header.php
│
├── modules/ # CRUD: products, users, categories, dll
│ ├── categories/
│ │ ├── create.php
│ │ ├── delete.php
│ │ ├── edit.php
│ │ └── index.php
│ ├── logs/
│ │ └── index.php
│ ├── products/
│ │ ├── create.php
│ │ ├── delete.php
│ │ ├── edit.php
│ │ └── index.php
│ ├── report/
│ │ └── transaksi.php
│ ├── settings/
│ │ └── index.php
│ ├── suppliers/
│ │ ├── create.php
│ │ ├── delete.php
│ │ ├── edit.php
│ │ └── index.php
│ ├── transactions/
│ │ ├── checkout.php
│ │ ├── create.php
│ │ ├── detail.php
│ │ ├── dummy_order.php
│ │ ├── index.php
│ │ ├── konfirmasi.php
│ │ ├── pending.php
│ │ ├── proses.php
│ │ └── successdex.php
| └── Users/
│   ├── create.php
│   ├── delete.php
│   ├── edit.php
│   └── index.php
│
├── pages/
│ ├── admin/
│ │ ├── users.php
│ │ ├── logout.php
│ │ └── dashboard.php
│ ├── kasir/
│ │ ├── riwayat.php
│ │ ├── logout.php
│ │ └── dashboard.php
│ ├── shop/
│ │ ├── index.php # Katalog produk utama
│ │ ├── detail.php # Halaman detail produk
│ │ ├── keranjang.php # Isi keranjang
│ │ ├── checkout.php # Form checkout + simpan pesanan
│ │ ├── riwayat.php # Riwayat transaksi pelanggan
│ │ ├── struk.php # Detail struk/invoice
| | ├── cetak_pdf.php # Form cetak struk dalam bentuk pdf
│ │ ├── hapus_keranjang.php # Fitur menghapus keranjang
│ │ └── isi_data.php # Data pelanggan
│ └── user/
│   ├── register.php
│   ├── login.php
│   ├── logout.php
|   ├── profil.php
│   └── dashboard.php
│
├── report/ # Laporan penjualan & pengguna
│ ├── cetak_laporan.php
│ ├── laporan_pengguna.php
│ ├── laporan_penjualan.php
│ ├── laporan_transaksi.php
│ └── struk_admin.php
│
├── sql/ # File SQL database
│ └── mbetaro.sql
│
├── uploads/ # Gambar produk berdasarkan kategori
│ ├── atasan_pria
│ ├── atasan_Wanita
│ ├── bawahan_pria
│ ├── bawahan_wanita
| ├── jaket
│ ├── sepatu
│ ├── tas
│ └── produk.csv #Data produk
│
├── vendor
│ ├── composer
│ ├── dompdf
│ ├── masterminds
│ ├── sabberworm
| └── autoload.php
│
├── add_to_cart.php
├── composer.json
├── composer.lock
├── import_produk.php
├── index.php # Landing page / redirect
└── README.md
```

---

## 🛠️ Teknologi Digunakan

| Layer       | Teknologi                            |
|-------------|--------------------------------------|
| **Backend** | PHP 7.4+                             |
| **Database**| MySQL 5.7+                           |
| **Frontend**| HTML, CSS, Bootstrap 4               |
| **Lainnya** | DOMPDF (cetak PDF), Composer         |

---

## 🧠 Alur Penggunaan Aplikasi

1. 🔐 **Registrasi & Login**  
   - Pengguna mendaftar & login  
   - Sistem membaca role: admin, kasir, atau pelanggan

2. 🛒 **Menjelajahi Produk**  
   - Pelanggan melihat katalog & filter berdasarkan kategori

3. 👚 **Detail Produk & Keranjang**  
   - Pilih ukuran (S, M, L, XL)  
   - Tambahkan produk ke keranjang (disimpan di session)

4. 🧾 **Checkout Pesanan**  
   - Isi data diri  
   - Submit ke sistem → masuk ke tabel `orders` dan `order_items`

5. 💼 **Pemrosesan oleh Kasir**  
   - Kasir login  
   - Mengubah status transaksi menjadi "Diproses"

6. 📃 **Cetak Struk & Riwayat**  
   - Pelanggan melihat riwayat pesanan  
   - Bisa mencetak struk via halaman `struk.php` atau PDF

---

## 🔐 Hak Akses User

| Role         | Halaman Login              | Akses Modul                                        |
|--------------|----------------------------|----------------------------------------------------|
| **Admin**    | `pages/user/login.php`     | Produk, Kategori, Supplier, User, Laporan          |
| **Kasir**    | `pages/user/login.php`     | Transaksi, Proses Pesanan                          |
| **Pelanggan**| `pages/user/login.php`     | Belanja, Checkout, Riwayat, Data Profil            |

---

## 🧾 Struktur Database

📂 File SQL: `sql/mbetaro.sql`  
📎 ERD: Tersedia di `docs/mbetaro.dbml.pdf` dan `docs/mbetaro.dbml.png`

---

### Tabel-Tabel Utama:

| Tabel            | Keterangan                              |
|------------------|-----------------------------------------|
| `users`          | Data login semua role                   |
| `customers`      | Data pelanggan & alamat lengkap         |
| `products`       | Informasi produk fashion                |
| `categories`     | Kategori produk                         |
| `orders`         | Header transaksi pesanan                |
| `order_items`    | Detail isi pesanan + ukuran             |
| `returns`        | Data pengembalian produk                |
| `suppliers`      | Info supplier produk                    |
| `activity_logs`  | Log aktivitas admin                     |
| `settings`       | Konfigurasi global toko                 |
📌 Ukuran produk disimpan di tabel `order_items` kolom `size`

---

## 🖼️ Preview Tampilan

- 🎨 Warna dominan: **Lavender**, **Peach**, **Rose Pink**
- 📱 Responsif di perangkat desktop & mobile
- 🛒 Layout seperti e-commerce modern

---

## 📄 Lisensi

Proyek ini dibuat sebagai bagian dari tugas UAS dan pembelajaran pribadi.  
🚫 **Tidak untuk dikomersialkan tanpa izin.**  
✅ Boleh digunakan untuk referensi edukasi dengan mencantumkan sumber.

---

## 👩‍💻 Tentang Pengembang

| Nama Lengkap     | Maharani Putri          |
|------------------|-------------------------|
| NIM              | 202312001               |
| Jurusan          | Teknik Informatika      |
| Kampus/Instansi  | STITEK Bontang          |

---