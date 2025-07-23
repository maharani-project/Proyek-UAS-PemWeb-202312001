## 🛠️ INSTALLATION GUIDE – MbetaRO Fashion Web App
Dokumen ini berisi langkah-langkah untuk melakukan instalasi dan menjalankan aplikasi web dinamis MbetaRO secara lokal di komputer Anda.

---

## 📋 Persyaratan Sistem
Pastikan Anda telah menginstal software berikut:

| Komponen   | Versi Minimum                          |
| ---------- | -------------------------------------- |
| PHP        | 7.4 atau lebih baru                    |
| MySQL      | 5.7 atau lebih baru                    |
| Web Server | Apache (XAMPP / Laragon / LAMP)        |
| Browser    | Modern Browser (Chrome, Edge, Firefox) |


---

## 📁 Struktur Direktori Utama

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

## 🔌 Langkah Instalasi
1. Clone atau Download Project
```bash
git clone https://github.com/username/mbetaro.git
```

---

2. Setup Database
   - Buka phpMyAdmin.
   - Buat database baru dengan nama: mbetaro.
   - Import file SQL: Masuk ke database mbetaro, Klik Import, Pilih file sql/mbetaro.sql, Klik Go.

---      

3. Konfigurasi Database
Edit file config/db.php dan sesuaikan kredensial Anda:

```bash
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan jika ada password
$db   = "mbetaro";
```

---

4. Jalankan Aplikasi
Buka browser dan akses:

```bash
http://localhost/mbetaro/
```

---

## 🔐 Login Akun Default

| Role  | Username               | Password |
| ----- | ---------------------- | -------- |
| Admin | admin                  | admin123 |
| Kasir | kasir                  | kasir123 |
| User  | Buat akun via register |          |

---

## 📸 Gambar Produk
1. Gambar produk berada di dalam folder uploads/ dan terbagi per kategori.
2. Penamaan folder sesuai dengan category_id, contoh:
   - uploads/blouse/
   - uploads/crop/
   - uploads/atasan_pria/

---

## 🧩 Masalah Umum
1. Jika halaman blank → pastikan PHP ≥ 7.4 dan display_errors aktif.
2. Jika gambar tidak muncul → pastikan struktur folder uploads/ benar dan file gambar tersedia.

---

## ☎️ Kontak Developer
Jika Anda mengalami kendala, silakan hubungi:

Nama: [Maharani Putri]
Email: [maharaniputri954@gmail.com]
GitHub: https://github.com/maharani-project

---