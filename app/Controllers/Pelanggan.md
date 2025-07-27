# Dokumentasi Modul Lapangan

Modul ini bertanggung jawab untuk mengelola semua data master yang berkaitan dengan lapangan olahraga, seperti menambah, melihat, mengubah, dan menghapus data lapangan.

## Ringkasan Fitur

- **CRUD Lapangan**: Membuat, membaca, memperbarui, dan menghapus data lapangan.
- **Manajemen Informasi**: Mengelola detail lapangan seperti nama, jenis olahraga, dan harga sewa per jam.

---

## File Terkait

- **Controller**: `app/Controllers/Lapangan.php`
- **Model**: `app/Models/LapanganModel.php`
- **Views**:
    - `dashboard/lapangan/lapangan.php` (Menampilkan daftar lapangan dan form tambah)
    - `dashboard/lapangan/lapangan_edit.php` (Form untuk mengedit lapangan)

---

## Alur Kerja Controller (`Lapangan.php`)

Berikut adalah penjelasan untuk setiap fungsi utama di dalam controller.

### `index()`
- **Rute**: `GET /lapangan`
- **Fungsi**: Menampilkan halaman utama yang berisi daftar semua lapangan yang tersedia.

### `tambah()`
- **Rute**: `POST /lapangan/tambah`
- **Fungsi**: Memproses data yang dikirim dari form tambah lapangan. Fungsi ini menerima `nama_lapangan`, `jenis_olahraga`, dan `harga_per_jam`, lalu menyimpannya ke database.

### `edit($id)`
- **Rute**: `GET /lapangan/edit/{id}`
- **Fungsi**: Menampilkan halaman form untuk mengedit data lapangan yang sudah ada. Data lapangan diambil berdasarkan ID yang diberikan.

### `update($id)`
- **Rute**: `POST /lapangan/update/{id}`
- **Fungsi**: Memproses data yang dikirim dari form edit. Fungsi ini akan memperbarui data lapangan di database sesuai dengan ID yang diberikan.

### `hapus($id)`
- **Rute**: `GET /lapangan/hapus/{id}`
- **Fungsi**: Menghapus data lapangan dari database berdasarkan ID.

---

## Catatan Tambahan

- **Keamanan**: Sama seperti modul lainnya, untuk operasi `hapus($id)`, sangat disarankan untuk mengubah metode HTTP dari `GET` ke `POST` atau `DELETE` untuk meningkatkan keamanan dan mencegah penghapusan data yang tidak disengaja melalui URL.
- **Validasi**: Untuk keandalan data, sebaiknya tambahkan aturan validasi di method `tambah()` dan `update()` untuk memastikan semua input yang diterima sesuai format yang diharapkan (misalnya, `harga_per_jam` harus berupa angka).

---

## Struktur Tabel (`lapangan`)

- `id` (INT, Primary Key, Auto Increment)
- `nama_lapangan` (VARCHAR)
- `jenis_olahraga` (VARCHAR)
- `harga_per_jam` (DECIMAL)

