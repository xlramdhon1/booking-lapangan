# Dokumentasi Modul Booking

Modul ini bertanggung jawab untuk mengelola semua operasi yang terkait dengan pemesanan (booking) lapangan, mulai dari pembuatan, penampilan, pembaruan, hingga penghapusan data booking.

## Ringkasan Fitur

- **CRUD Booking**: Membuat, membaca, memperbarui, dan menghapus data booking.
- **Filter Data**: Menyaring daftar booking berdasarkan status, tanggal, dan lapangan.
- **Pencegahan Jadwal Bentrok**: Validasi untuk memastikan tidak ada booking ganda pada waktu yang sama.
- **Ekspor Laporan**: Mengunduh data booking dalam format PDF dan Excel.
- **Manajemen Status**: Mengubah status booking (misalnya dari `pending` menjadi `confirmed`).

---

## File Terkait

- **Controller**: `app/Controllers/Booking.php`
- **Model**: `app/Models/BookingModel.php`
- **Views**:
    - `dashboard/booking/booking_list.php`
    - `dashboard/booking/booking_tambah.php`
    - `dashboard/booking/booking_edit.php`
    - `dashboard/booking/status_list.php`
    - `dashboard/booking/status_form.php`
    - `tampilan/admin/dashboard/pdf_booking_list.php` (Template PDF)
- **Helper**: `app/Helpers/booking_helper.php`

---

## Alur Kerja Controller (`Booking.php`)

Berikut adalah penjelasan untuk setiap fungsi utama di dalam controller.

### `index()`
- **Rute**: `GET /booking`
- **Fungsi**: Menampilkan halaman utama daftar booking. Mendukung filter berdasarkan `status`, `tanggal`, dan `lapangan_id` melalui query string.
- **Contoh URL dengan filter**: `/booking?status=pending&tanggal=2024-07-25`

### `tambah()`
- **Rute**: `GET /booking/tambah`
- **Fungsi**: Menampilkan form untuk menambah data booking baru. Mengambil data pelanggan dan lapangan untuk ditampilkan di dropdown.

### `simpan()`
- **Rute**: `POST /booking/simpan`
- **Fungsi**: Menyimpan data booking baru ke database. Sebelum menyimpan, fungsi ini memanggil helper `isConflictBooking()` untuk memeriksa apakah jadwal yang dipilih bentrok dengan booking lain.

### `edit($id)`
- **Rute**: `GET /booking/edit/{id}`
- **Fungsi**: Menampilkan form untuk mengedit data booking yang sudah ada berdasarkan ID.

### `update($id)`
- **Rute**: `POST /booking/update/{id}`
- **Fungsi**: Memperbarui data booking di database. Sama seperti `simpan()`, fungsi ini juga melakukan pengecekan jadwal bentrok. Selain itu, fungsi ini juga menghitung ulang `total_bayar` berdasarkan durasi dan harga sewa lapangan.

### `hapus($id)`
- **Rute**: `GET /booking/hapus/{id}` (Disarankan menggunakan `POST` atau `DELETE` untuk keamanan)
- **Fungsi**: Menghapus data booking dari database berdasarkan ID.

### `statusList()` & `statusForm($id)` & `statusUpdate($id)`
- **Rute**:
    - `GET /booking/status`
    - `GET /booking/status/form/{id}`
    - `POST /booking/status/update/{id}`
- **Fungsi**: Kumpulan metode untuk mengelola perubahan status booking secara terpisah.

### `updateStatus()`
- **Rute**: `POST /booking/update-status` (API Endpoint)
- **Fungsi**: Endpoint yang dipanggil via JavaScript (AJAX/Fetch) untuk mengubah status booking menjadi `confirmed` dan metode pembayaran menjadi `midtrans`. Biasanya digunakan setelah pembayaran berhasil.

---

## Fitur Ekspor

### `exportPdf()`
- **Rute**: `GET /booking/export/pdf`
- **Fungsi**: Menghasilkan file PDF berisi daftar booking. Data yang diekspor dapat difilter menggunakan query string yang sama dengan method `index()`. Menggunakan library `dompdf/dompdf`.
- **Contoh URL**: `/booking/export/pdf?status=confirmed`

### `exportExcel()`
- **Rute**: `GET /booking/export/excel`
- **Fungsi**: Menghasilkan file Excel (`.xlsx`) berisi daftar booking. Data yang diekspor juga dapat difilter. Menggunakan library `phpoffice/phpspreadsheet`.
- **Contoh URL**: `/booking/export/excel?lapangan_id=1`

---

## Validasi Jadwal Bentrok

Logika untuk mencegah booking pada jadwal yang sudah terisi ditangani oleh fungsi `isConflictBooking()` yang ada di `app/Helpers/booking_helper.php`.

Fungsi ini dipanggil di dalam method `simpan()` dan `update()` sebelum data dimasukkan ke database. Jika terdeteksi bentrok, proses akan dihentikan dan pengguna akan dikembalikan ke halaman form dengan pesan error.

---

## Catatan Tambahan

- **Keamanan**: Untuk operasi destruktif seperti `hapus()`, disarankan untuk mengubah metode HTTP dari `GET` menjadi `POST` atau `DELETE` dan menambahkan perlindungan CSRF untuk mencegah aksi yang tidak diinginkan.
- **Rute**: Pastikan semua rute di atas telah terdaftar di `app/Config/Routes.php` agar dapat diakses.

```

Dokumentasi ini memberikan gambaran yang jelas tentang cara kerja modul Booking, yang akan sangat berguna untuk pengembangan dan pemeliharaan di masa mendatang.

<!--
[PROMPT_SUGGESTION]Buatkan saya file helper `app/Helpers/booking_helper.php` untuk validasi jadwal bentrok.[/PROMPT_SUGGESTION]
[PROMPT_SUGGESTION]Bagaimana cara mendaftarkan semua rute untuk controller Booking di `app/Config/Routes.php`?[/PROMPT_SUGGESTION]
