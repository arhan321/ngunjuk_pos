# Ngunjuk POS - Sistem Informasi Kasir Berbasis Website

## Deskripsi Project

**Ngunjuk POS** adalah aplikasi sistem informasi kasir berbasis website yang dibuat untuk membantu proses transaksi penjualan pada UMKM Ngunjuk. Sistem ini dirancang agar proses kasir, pengelolaan produk, pengelolaan kategori, pengelolaan ukuran produk, pencatatan transaksi, dan riwayat penjualan dapat dilakukan secara lebih rapi, cepat, dan terstruktur.

Project ini dibuat menggunakan **Laravel versi terbaru**, **Filament Admin Panel**, **Raugadh Filament Starter Kit**, serta **Spatie Permission** untuk pengelolaan role user. Sistem ini berfokus pada kebutuhan Point of Sale atau POS, tanpa fitur Simple Moving Average karena fitur prediksi sudah tidak digunakan setelah revisi.

---

## Tujuan Project

Tujuan utama dari project ini adalah membangun sistem kasir berbasis website yang dapat membantu UMKM Ngunjuk dalam:

1. Mencatat transaksi penjualan secara digital.
2. Mengelola data produk minuman.
3. Mengelola kategori produk.
4. Mengelola variasi ukuran produk seperti small, large, dan regular.
5. Mengurangi risiko kesalahan pencatatan transaksi manual.
6. Menampilkan riwayat transaksi secara otomatis.
7. Menyediakan dashboard admin untuk melihat ringkasan penjualan.
8. Membatasi akses sistem berdasarkan role user.

---

## Teknologi yang Digunakan

Project ini menggunakan beberapa teknologi utama berikut:

- **Laravel** sebagai framework backend utama.
- **Filament Admin Panel** sebagai dashboard admin.
- **Raugadh Filament Starter Kit** sebagai starter kit admin.
- **Spatie Laravel Permission** untuk role dan permission user.
- **MySQL / MariaDB** sebagai database.
- **Blade Template** sebagai frontend view.
- **JavaScript Vanilla** untuk interaksi halaman kasir dan history.
- **CSS Custom** untuk tampilan POS.
- **Docker** sebagai environment development.
- **Laravel Storage** untuk menyimpan dan menampilkan gambar produk.

---

## Role User

Sistem ini memiliki pembagian role user agar akses setiap pengguna lebih terkontrol.

### 1. Super Admin

Role `super_admin` memiliki akses penuh ke halaman admin Filament.

Hak akses super admin:

- Masuk ke halaman `/admin`.
- Melihat dashboard admin.
- Melihat widget statistik penjualan.
- Mengelola data kategori.
- Mengelola data produk.
- Mengelola data order.
- Mengelola user.
- Mengelola roles dan permissions.
- Melihat activity log.
- Export monthly revenue dari dashboard.

### 2. Karyawan

Role `karyawan` hanya digunakan untuk operasional kasir.

Hak akses karyawan:

- Masuk ke halaman kasir.
- Melakukan transaksi penjualan.
- Melihat halaman history.
- Melihat halaman settings.
- Tidak bisa masuk ke halaman `/admin`.
- Tidak bisa melihat dashboard Filament.
- Tidak bisa melihat widget admin.

---

## Fitur Utama

### 1. Login

User harus login terlebih dahulu sebelum menggunakan sistem. Login menggunakan email dan password yang sudah terdaftar di database.

Setelah login berhasil, user diarahkan ke halaman utama kasir.

---

### 2. Halaman Kasir / POS

Halaman kasir digunakan untuk melakukan transaksi penjualan. Pada halaman ini user dapat:

- Melihat daftar produk aktif.
- Melihat gambar produk.
- Melihat variasi ukuran produk.
- Memilih produk berdasarkan ukuran.
- Menambahkan produk ke cart.
- Mengubah jumlah pesanan.
- Menghapus item dari cart.
- Menyimpan transaksi ke database.

Ketika transaksi berhasil, data akan tersimpan ke tabel `orders` dan `order_items`.

---

### 3. Cart / Keranjang

Cart digunakan untuk menampung produk yang dipilih sebelum transaksi disimpan.

Fungsi cart:

- Menampilkan produk yang dipilih.
- Menampilkan ukuran produk.
- Menampilkan quantity.
- Menampilkan subtotal.
- Menghitung total transaksi.
- Mengirim data transaksi ke backend.

Saat order disimpan, data order dan item disimpan dalam satu transaksi database.

---

### 4. History Order

Halaman history digunakan untuk melihat riwayat transaksi yang sudah dilakukan.

Data yang ditampilkan pada history:

- ID order.
- Item yang dibeli.
- Waktu transaksi.
- Total transaksi.
- Status order.

Halaman history juga memiliki fitur:

- Search berdasarkan ID order atau nama produk.
- Filter order hari ini.
- Filter order kemarin.
- Filter order minggu ini.
- Filter order bulan ini.
- Filter semua order.
- Sorting terbaru.
- Sorting terlama.
- Sorting total terbesar.
- Sorting total terkecil.
- Filter status order.
- Export data history ke CSV.

Pada tampilan history, kartu statistik menampilkan total semua transaksi, sedangkan tabel dapat difilter sesuai kebutuhan.

---

### 5. Settings User

Halaman settings digunakan untuk melihat informasi akun user yang sedang login.

Data yang ditampilkan:

- Nama user.
- Email user.
- Role user.
- Status user.

Role user diambil dari data role yang tersedia melalui Spatie Permission.

---

### 6. Dashboard Admin Filament

Dashboard admin hanya bisa diakses oleh role `super_admin`.

Pada dashboard admin terdapat beberapa widget utama:

- Total revenue.
- Total orders.
- Units sold.
- Total product.
- Average order.
- Monthly revenue chart.
- Monthly units sold chart.
- Product by category chart.
- Top product sales.
- Daily units chart.
- Latest orders table.

Dashboard ini membantu pemilik UMKM melihat kondisi penjualan secara ringkas dan cepat.

---

### 7. Export Monthly Revenue

Pada dashboard admin terdapat fitur export monthly revenue.

Fitur ini digunakan untuk men-download laporan pendapatan bulanan dalam format file yang bisa dibuka melalui Excel.

Isi laporan export:

- Judul laporan.
- Nama sistem.
- Periode laporan.
- Total order.
- Total item terjual.
- Total revenue.
- Rata-rata revenue per bulan.
- Detail pendapatan bulanan.
- Footer waktu cetak laporan.

Fitur export ini hanya bisa digunakan oleh `super_admin`.

---

## Struktur Database

### 1. users

Tabel `users` digunakan untuk menyimpan data akun pengguna.

Kolom utama:

- `id`
- `avatar_url`
- `name`
- `email`
- `email_verified_at`
- `password`
- `remember_token`
- `created_at`
- `updated_at`

Model `User` menggunakan trait `HasRoles` dari Spatie Permission.

---

### 2. categories

Tabel `categories` digunakan untuk menyimpan kategori produk.

Kolom utama:

- `id`
- `name`
- `slug`
- `is_active`
- `created_at`
- `updated_at`

Relasi:

- Satu kategori memiliki banyak produk.

---

### 3. products

Tabel `products` digunakan untuk menyimpan data produk minuman.

Kolom utama:

- `id`
- `category_id`
- `name`
- `slug`
- `description`
- `image`
- `is_active`
- `created_at`
- `updated_at`

Relasi:

- Produk belongs to kategori.
- Produk memiliki banyak ukuran.
- Produk memiliki banyak order item.

---

### 4. product_sizes

Tabel `product_sizes` digunakan untuk menyimpan variasi ukuran produk.

Kolom utama:

- `id`
- `product_id`
- `name`
- `price`
- `is_default`
- `is_active`
- `created_at`
- `updated_at`

Contoh ukuran:

- Small
- Large
- Regular

Relasi:

- Satu ukuran produk belongs to satu produk.

---

### 5. orders

Tabel `orders` digunakan untuk menyimpan data transaksi utama.

Kolom utama:

- `id`
- `order_code`
- `total_item`
- `total_price`
- `status`
- `ordered_at`
- `created_at`
- `updated_at`

Status order:

- `Diproses`
- `Selesai`
- `Dibatalkan`

Pada sistem ini, transaksi kasir otomatis disimpan dengan status `Selesai`.

---

### 6. order_items

Tabel `order_items` digunakan untuk menyimpan detail produk pada setiap transaksi.

Kolom utama:

- `id`
- `order_id`
- `product_id`
- `product_size_id`
- `product_name`
- `size_name`
- `price`
- `quantity`
- `subtotal`
- `created_at`
- `updated_at`

Relasi:

- Order item belongs to order.
- Order item belongs to product.
- Order item belongs to product size.

---

## Struktur Folder Penting

Berikut beberapa struktur folder penting pada project:

```text
app/
├── Filament/
│   └── Admin/
│       ├── Pages/
│       │   └── Dashboard.php
│       └── Widgets/
│           ├── PosStatsOverview.php
│           ├── MonthlyRevenueChart.php
│           ├── MonthlyUnitsChart.php
│           ├── ProductCategoryChart.php
│           ├── TopProductsTable.php
│           ├── DailyUnitsChart.php
│           └── LatestOrdersTable.php
│
├── Http/
│   └── Controllers/
│       ├── AuthController.php
│       ├── FrontendController.php
│       ├── HistoryController.php
│       ├── OrderController.php
│       └── ProductController.php
│
└── Models/
    ├── User.php
    ├── Category.php
    ├── Product.php
    ├── ProductSize.php
    ├── Order.php
    └── OrderItem.php
```

```text
resources/
└── views/
    ├── index.blade.php
    ├── history.blade.php
    ├── settings.blade.php
    └── login.blade.php
```

```text
public/
├── css/
│   └── style.css
└── js/
    ├── app.js
    └── history.js
```

---

## Alur Sistem

### 1. Alur Login

1. User membuka halaman login.
2. User memasukkan email dan password.
3. Sistem melakukan validasi input.
4. Sistem mengecek data user.
5. Jika benar, user masuk ke halaman kasir.
6. Jika salah, sistem menampilkan pesan error.

---

### 2. Alur Transaksi Kasir

1. User membuka halaman kasir.
2. Sistem mengambil data produk aktif dari database.
3. User memilih produk dan ukuran.
4. Produk masuk ke cart.
5. User menentukan jumlah pesanan.
6. User menekan tombol checkout.
7. Sistem memvalidasi produk, ukuran, dan quantity.
8. Sistem membuat data order.
9. Sistem membuat data order item.
10. Sistem menampilkan pesan transaksi berhasil.

---

### 3. Alur History Order

1. User membuka halaman history.
2. Sistem mengambil data order dari database.
3. Sistem menampilkan data transaksi pada tabel.
4. User dapat mencari order berdasarkan ID atau produk.
5. User dapat memfilter berdasarkan tanggal.
6. User dapat melakukan sorting.
7. User dapat export data history.

---

### 4. Alur Admin Dashboard

1. Super admin masuk ke halaman `/admin`.
2. Sistem menampilkan dashboard Filament.
3. Dashboard mengambil data transaksi dari database.
4. Sistem menampilkan statistik penjualan.
5. Super admin dapat melihat grafik dan tabel.
6. Super admin dapat export laporan monthly revenue.

---

## Instalasi Project

### 1. Clone Project

```bash
git clone <url-repository>
cd <nama-folder-project>
```

---

### 2. Install Dependency

```bash
composer install
```

Jika menggunakan Vite atau asset frontend Laravel:

```bash
npm install
npm run build
```

---

### 3. Buat File Environment

```bash
cp .env.example .env
```

Lalu sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=password_database
```

Jika menggunakan Laragon, sesuaikan host, username, dan password dengan konfigurasi lokal.

---

### 4. Generate App Key

```bash
php artisan key:generate
```

---

### 5. Jalankan Migration

```bash
php artisan migrate
```

Jika ingin reset database:

```bash
php artisan migrate:fresh
```

---

### 6. Buat Storage Link

```bash
php artisan storage:link
```

Perintah ini digunakan agar gambar produk yang disimpan di storage dapat diakses dari browser.

---

### 7. Buat Role User

Masuk ke tinker:

```bash
php artisan tinker
```

Lalu jalankan:

```php
use Spatie\Permission\Models\Role;

Role::firstOrCreate([
    'name' => 'super_admin',
    'guard_name' => 'web',
]);

Role::firstOrCreate([
    'name' => 'karyawan',
    'guard_name' => 'web',
]);
```

---

### 8. Berikan Role ke User

Contoh menjadikan user sebagai super admin:

```php
use App\Models\User;

$user = User::where('email', 'admin@admin.com')->first();

$user->syncRoles(['super_admin']);
```

Contoh menjadikan user sebagai karyawan:

```php
use App\Models\User;

$user = User::where('email', 'karyawan@gmail.com')->first();

$user->syncRoles(['karyawan']);
```

---

### 9. Clear Cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

---

### 10. Jalankan Project

```bash
php artisan serve
```

Jika menggunakan Docker, jalankan melalui container sesuai konfigurasi project.

---

## Akses Halaman

### Halaman Login

```text
http://localhost/login
```

### Halaman Kasir

```text
http://localhost/
```

atau

```text
http://localhost/kasir
```

### Halaman History

```text
http://localhost/history
```

### Halaman Settings

```text
http://localhost/settings
```

### Halaman Admin Filament

```text
http://localhost/admin
```

Catatan: hanya role `super_admin` yang bisa mengakses halaman admin.

---

## API yang Digunakan

### 1. API Produk

Digunakan untuk mengambil data produk aktif yang ditampilkan pada halaman kasir.

```text
GET /api/products
```

Response berisi data produk, kategori, ukuran, harga, dan gambar.

---

### 2. API Order

Digunakan untuk menyimpan transaksi kasir.

```text
POST /api/orders
```

Contoh data request:

```json
{
  "items": [
    {
      "product_id": 1,
      "product_size_id": 1,
      "quantity": 2
    }
  ]
}
```

---

### 3. API History

Digunakan untuk mengambil riwayat transaksi.

```text
GET /api/history
```

Parameter yang tersedia:

```text
search
status
date_filter
sort
```

Contoh:

```text
/api/history?date_filter=today&sort=latest&status=all
```

Pilihan `date_filter`:

```text
today
yesterday
week
month
all
```

Pilihan `sort`:

```text
latest
oldest
highest
lowest
```

---

## Validasi Transaksi

Pada saat checkout, sistem melakukan beberapa validasi:

1. Cart tidak boleh kosong.
2. Product ID harus valid.
3. Product size ID harus valid.
4. Quantity minimal 1.
5. Ukuran produk harus aktif dan sesuai dengan produk.

---

## Logic Order Code

Setiap order memiliki kode otomatis.

Format order:

```text
ORD-YYYYMMDD-0001
```

Contoh:

```text
ORD-20260530-0001
ORD-20260530-0002
ORD-20260530-0003
```

Nomor order akan bertambah otomatis berdasarkan transaksi pada hari yang sama.

---

## Keamanan Akses Admin

Akses admin dikontrol melalui method `canAccessPanel()` pada model `User`.

Hanya user dengan role `super_admin` yang bisa masuk ke halaman admin Filament.

Role `karyawan` tidak dapat masuk ke halaman admin dan hanya digunakan untuk operasional kasir.

---

## Catatan Pengembangan

Fitur Simple Moving Average tidak digunakan pada versi project ini karena sudah mengalami revisi. Project ini difokuskan menjadi sistem POS berbasis website untuk mendukung transaksi, pengelolaan produk, dan laporan penjualan UMKM Ngunjuk.

---

## Kesimpulan

Ngunjuk POS merupakan sistem informasi kasir berbasis website yang dirancang untuk membantu UMKM Ngunjuk dalam proses digitalisasi transaksi penjualan. Dengan fitur kasir, cart, pengelolaan produk, history order, dashboard admin, role user, dan export laporan, sistem ini dapat membantu proses operasional menjadi lebih cepat, rapi, dan mudah dipantau.

Sistem ini juga mendukung pembagian akses antara super admin dan karyawan, sehingga pengelolaan data admin tetap aman dan hanya dapat diakses oleh pengguna yang berwenang.

---

## Developer

Project ini dibuat untuk kebutuhan Tugas Akhir / Skripsi Sistem Informasi.

**Nama Project:** Ngunjuk POS  
**Jenis Sistem:** Sistem Informasi Kasir Berbasis Website  
**Studi Kasus:** UMKM Ngunjuk  
**Framework:** Laravel  
**Admin Panel:** Filament  
**Starter Kit:** Raugadh Filament Starter Kit  
