# Proyek Aplikasi Booking Lapangan

Aplikasi web untuk melakukan pemesanan (booking) lapangan olahraga. Dibangun menggunakan CodeIgniter 4 di sisi backend, serta HTML, Tailwind CSS, dan JavaScript di sisi frontend. Dilengkapi juga dengan gerbang pembayaran Midtrans.

## Tentang Proyek

Tujuan dari proyek ini adalah untuk menyediakan platform digital yang memudahkan pengguna dalam mencari, melihat jadwal ketersediaan, dan memesan lapangan olahraga secara online. Administrator dapat mengelola data lapangan, jadwal, dan laporan pemesanan.

---

### Dibangun Dengan

Berikut adalah teknologi utama yang digunakan dalam proyek ini:

**Backend:**
*   [CodeIgniter 4](https://codeigniter.com/) - Framework PHP
*   [Midtrans PHP Library](https://github.com/Midtrans/midtrans-php) - Untuk proses pembayaran
*   [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) - Untuk membuat dan membaca file Excel
*   [Dompdf](https://github.com/dompdf/dompdf) - Untuk membuat file PDF

**Frontend:**
*   HTML5
*   [Tailwind CSS](https://tailwindcss.com/) - Framework CSS
*   [FullCalendar](https://fullcalendar.io/) - Untuk menampilkan jadwal booking
*   [SweetAlert2](https://sweetalert2.github.io/) - Untuk notifikasi dan pop-up interaktif

**Database:**
*   MySQL (atau database lain yang didukung CodeIgniter 4)

---

## Memulai

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Prasyarat

Pastikan perangkat Anda sudah terinstall:
*   PHP 8.1 atau lebih baru
*   Composer
*   Node.js dan NPM
*   Web Server (misalnya XAMPP, Nginx)
*   Database (misalnya MySQL/MariaDB)

### Instalasi

1.  **Clone repository**
    ```sh
    git clone <url-repository-anda>
    cd booking-lapangan
    ```

2.  **Install dependensi PHP**
    ```sh
    composer install
    ```

3.  **Install dependensi JavaScript**
    ```sh
    npm install
    ```

4.  **Konfigurasi Environment**
    *   Salin file `env` menjadi `.env`.
    *   Buka file `.env` dan sesuaikan konfigurasi berikut:
        *   `CI_ENVIRONMENT = development`
        *   `app.baseURL = 'http://localhost:8080'`
        *   Konfigurasi database (host, database, user, password).
        *   Konfigurasi Midtrans (Server Key & Client Key).

5.  **Buat Database**
    *   Buat sebuah database baru di MySQL sesuai dengan nama yang Anda atur di file `.env`.

6.  **Jalankan Migrasi Database**
    Jalankan perintah ini dari terminal di root proyek untuk membuat tabel-tabel yang dibutuhkan.
    ```sh
    php spark migrate
    ```

7.  **Jalankan Server Development**
    ```sh
    php spark serve
    ```
    Aplikasi Anda sekarang akan berjalan di `http://localhost:8080`.

---

## Fitur Utama

*   ✅ **Manajemen Booking:** Pengguna dapat memesan lapangan berdasarkan jadwal yang tersedia.
*   📅 **Kalender Interaktif:** Jadwal ketersediaan lapangan ditampilkan menggunakan FullCalendar.
*   💳 **Pembayaran Online:** Terintegrasi dengan Midtrans untuk berbagai metode pembayaran.
*   📄 **Laporan:** Admin dapat mengunduh laporan pemesanan dalam format PDF atau Excel.
*   🔐 **Autentikasi:** Sistem login untuk pengguna dan admin.

---

## Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.