# Dokumentasi Modul Payment (Midtrans)

Modul ini bertanggung jawab untuk mengelola seluruh alur proses pembayaran menggunakan gerbang pembayaran Midtrans. Ini mencakup pembuatan token pembayaran, penampilan halaman pembayaran, dan penanganan notifikasi (webhook) dari Midtrans.

## Ringkasan Fitur

- **Integrasi Midtrans Snap**: Menggunakan Midtrans Snap untuk antarmuka pembayaran yang modern dan mendukung berbagai metode.
- **Pembuatan Token**: Menghasilkan Snap Token secara dinamis untuk setiap transaksi booking.
- **Halaman Pembayaran**: Menyediakan halaman khusus di mana pengguna dapat melihat detail booking dan memulai pembayaran.
- **Penanganan Notifikasi (Webhook)**: Menerima dan memproses notifikasi status transaksi dari Midtrans untuk memperbarui status booking secara otomatis.

---

## File Terkait

- **Controller**: `app/Controllers/Payment.php`
- **Konfigurasi**: `app/Config/Midtrans.php`
- **View**: `dashboard/payment/pay_view.php`

---

## Alur Kerja Controller (`Payment.php`)

Berikut adalah penjelasan untuk setiap fungsi utama di dalam controller.

### `__construct()`
- **Fungsi**: Menginisialisasi konfigurasi Midtrans (Server Key, Production/Sandbox Mode) yang diambil dari file `app/Config/Midtrans.php`.

### `bayar($id)`
- **Rute**: `GET /payment/bayar/{id}`
- **Fungsi**:
    1.  Mengambil detail booking berdasarkan ID.
    2.  Memastikan booking tersebut ada dan statusnya masih `pending`.
    3.  Menampilkan halaman pembayaran (`pay_view.php`) yang berisi rincian booking dan tombol "Bayar Sekarang".

### `tokenize()`
- **Rute**: `POST /payment/tokenize` (Endpoint API)
- **Fungsi**:
    1.  Dipanggil oleh JavaScript (AJAX/Fetch) saat pengguna menekan tombol "Bayar Sekarang".
    2.  Menerima `booking_id` dalam format JSON.
    3.  Mengambil detail booking dan pelanggan dari database.
    4.  Membuat parameter transaksi yang dibutuhkan oleh Midtrans.
    5.  Meminta Snap Token ke Midtrans.
    6.  Mengembalikan Snap Token ke frontend dalam format JSON.

### `notification()`
- **Rute**: `POST /payment/notification` (Webhook Endpoint)
- **Fungsi**:
    1.  Endpoint ini diakses oleh server Midtrans, bukan oleh pengguna.
    2.  Menerima notifikasi status transaksi (misalnya, `settlement`, `capture`, `expire`).
    3.  Mengekstrak `order_id` untuk mendapatkan `booking_id`.
    4.  Memperbarui status booking di database sesuai dengan status transaksi:
        - `settlement` atau `capture` → status booking menjadi `confirmed`.
        - `cancel` atau `expire` → status booking menjadi `cancelled`.
    5.  Mengirimkan respons HTTP status `200` ke Midtrans untuk mengonfirmasi bahwa notifikasi telah diterima.

---

## Alur Pembayaran (End-to-End)

1.  **Admin/User** membuat booking baru, yang status awalnya adalah `pending`.
2.  Dari daftar booking, pengguna memilih booking yang ingin dibayar dan diarahkan ke halaman `/payment/bayar/{id}`.
3.  Pengguna melihat detail booking dan menekan tombol **"Bayar Sekarang"**.
4.  JavaScript di halaman tersebut mengirim request ke endpoint `/payment/tokenize`.
5.  Controller `Payment` menghasilkan **Snap Token** dan mengirimkannya kembali ke browser.
6.  JavaScript menggunakan token tersebut untuk membuka pop-up Midtrans Snap.
7.  Pengguna menyelesaikan pembayaran melalui pop-up Midtrans.
8.  Setelah pembayaran selesai, server Midtrans mengirim notifikasi ke endpoint webhook `/payment/notification`.
9.  Controller `Payment` menerima notifikasi, memvalidasinya, dan memperbarui status booking di database menjadi `confirmed`.

---

## Konfigurasi

Pastikan Anda telah mengatur kredensial Midtrans Anda di file `app/Config/Midtrans.php`.

```php
// app/Config/Midtrans.php
class Midtrans extends BaseConfig
{
    public $serverKey = 'YOUR_SERVER_KEY';
    public $clientKey = 'YOUR_CLIENT_KEY';
    public $isProduction = false;
    // ...
}
```

Selain itu, URL webhook (`http://your-domain.com/payment/notification`) harus didaftarkan di dashboard Midtrans Anda.

