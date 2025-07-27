# Dokumentasi Modul Admin Dashboard

Modul ini berfungsi sebagai halaman utama bagi administrator setelah login. Halaman ini menampilkan ringkasan data penting dari seluruh aplikasi dalam bentuk statistik dan kalender visual.

## Ringkasan Fitur

- **Statistik Utama**: Menampilkan jumlah total pelanggan, rincian booking per lapangan, dan rekapitulasi status booking.
- **Kalender Booking**: Visualisasi jadwal booking yang sudah dikonfirmasi (`confirmed`) dan selesai (`completed`) menggunakan FullCalendar.
- **Data Terpusat**: Mengumpulkan data dari berbagai model (`PelangganModel`, `LapanganModel`, `BookingModel`) untuk disajikan dalam satu halaman.

---

## File Terkait

- **Controller**: `app/Controllers/AdminDashboard.php`
- **Models**:
    - `app/Models/PelangganModel.php`
    - `app/Models/LapanganModel.php`
    - `app/Models/BookingModel.php`
- **View**: `tampilan/admin/dashboard/admin_dashboard.php`

---

## Alur Kerja Controller (`AdminDashboard.php`)

Controller ini hanya memiliki satu method publik utama, yaitu `index()`.

### `index()`
- **Rute**: `GET /dashboard` atau `GET /admin/dashboard`
- **Fungsi**: Mengumpulkan, memproses, dan mengirimkan data agregat ke view dashboard.

**Data yang Dikumpulkan:**

1.  **`$jumlahPelanggan`**: Menghitung total baris dari tabel `pelanggan`.
2.  **`$bookingPerLapangan`**: Menghitung jumlah booking untuk setiap lapangan yang ada. Hasilnya adalah array, masing-masing berisi `nama_lapangan` dan `jumlah_booking`.
3.  **`$bookingStatusCount`**: Menghitung jumlah booking untuk setiap status (`pending`, `confirmed`, `completed`, `cancelled`).
4.  **`$calendarEvents`**: Mengambil data booking yang berstatus `confirmed` atau `completed` dan mengubahnya menjadi format yang sesuai untuk FullCalendar.

**Struktur Data `$calendarEvents` yang Dikirim ke View:**
Setiap event dalam array ini memiliki struktur sebagai berikut:
```json
{
  "title": "Nama Pelanggan - Nama Lapangan",
  "start": "YYYY-MM-DDTHH:MM:SS",
  "end": "YYYY-MM-DDTHH:MM:SS",
  "color": "#xxxxxx",
  "extendedProps": {
    "nama_pelanggan": "Nama Pelanggan",
    "nama_lapangan": "Nama Lapangan",
    "tanggal": "YYYY-MM-DD",
    "jam_mulai": "HH:MM",
    "durasi": 2,
    "status": "Confirmed",
    "total_bayar": "150.000"
  }
}
```

### `getColorForStatus($status)`
- **Fungsi**: Method `protected` internal yang digunakan untuk memberikan kode warna hex berdasarkan status booking. Warna ini digunakan oleh `calendarEvents` untuk membedakan tampilan visual di kalender.

---

## Penggunaan di View

Data yang dikirim dari controller digunakan di view `admin_dashboard.php` untuk:
- Menampilkan kartu statistik (Jumlah Pelanggan, dll.).
- Membuat chart (misalnya, diagram batang untuk booking per lapangan).
- Menginisialisasi FullCalendar dengan data dari `$calendarEvents` untuk menampilkan jadwal secara visual.

