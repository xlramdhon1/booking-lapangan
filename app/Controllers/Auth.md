# Dokumentasi Modul Autentikasi (Auth)

Modul ini bertanggung jawab untuk menangani semua proses autentikasi administrator, termasuk proses login dan logout dari sistem.

## Ringkasan Fitur

- **Login Administrator**: Memverifikasi kredensial (username dan password) admin.
- **Manajemen Sesi**: Membuat dan menghancurkan sesi login untuk admin.
- **Logout**: Mengakhiri sesi admin yang aktif dan mengarahkan kembali ke halaman login.

---

## File Terkait

- **Controller**: `app/Controllers/Auth.php`
- **Model**: `app/Models/AdminModel.php`
- **View**: `auth/login.php`

---

## Alur Kerja Controller (`Auth.php`)

Berikut adalah penjelasan untuk setiap fungsi utama di dalam controller.

### `index()`
- **Rute**: `GET /login` atau `GET /`
- **Fungsi**: Menampilkan halaman form login (`auth/login.php`) kepada pengguna. Ini adalah halaman *default* saat aplikasi pertama kali diakses.

### `login()`
- **Rute**: `POST /auth/login`
- **Fungsi**:
    1.  Menerima `username` dan `password` dari form login.
    2.  Mencari admin di database berdasarkan `username` menggunakan `AdminModel`.
    3.  Jika admin ditemukan, memverifikasi password yang diinput dengan hash password di database menggunakan `password_verify()`.
    4.  Jika verifikasi berhasil, membuat sesi untuk admin dengan data:
        - `isLoggedIn` = `true`
        - `username` = `(username admin)`
    5.  Mengarahkan admin ke halaman `/dashboard`.
    6.  Jika username tidak ditemukan atau password salah, mengarahkan kembali ke halaman `/login` dengan pesan error.

### `logout()`
- **Rute**: `GET /auth/logout`
- **Fungsi**:
    1.  Menghancurkan semua data sesi yang ada menggunakan `session()->destroy()`.
    2.  Mengarahkan pengguna kembali ke halaman `/login`.

---

## Catatan

- **Keamanan**: Password disimpan dalam bentuk *hash* di database dan diverifikasi menggunakan `password_verify()`, yang merupakan praktik keamanan yang baik.
- **Rute**: Rute untuk modul ini didefinisikan di `app/Config/Routes.php`.

