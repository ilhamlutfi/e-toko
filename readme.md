# E-Toko

E-Toko adalah aplikasi berbasis web yang dibangun menggunakan OOP PHP 8, SB Admin Boostrap 4 Template dan MySQL. Aplikasi ini menyediakan fitur CRUD (Create, Read, Update, Delete) untuk produk, serta fungsionalitas login, logout, dan penambahan pengguna. E-Toko dirancang untuk memenuhi kebutuhan sertifikasi Web Programmer dari Jobhun dan LSP Telematika.

## Daftar Isi
- [Fitur](#fitur)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Cara Menggunakan](#cara-menggunakan)

## Fitur

- **CRUD Products:** 
    - Tambah produk baru
    - Edit informasi produk
    - Hapus produk
    - Tampilkan daftar produk

- **Autentikasi:**
    - Login untuk pengguna terdaftar
    - Logout untuk keluar dari sesi

- **Manajemen Pengguna:**
    - Tambah pengguna baru

## Prasyarat

- Sebelum menjalankan aplikasi ini, pastikan Anda memiliki:
    - PHP 8
    - MySQL
    - Server web (seperti Apache atau Nginx)

## Instalasi

- Cara instalasi project:
    - git clone https://github.com/username/e-toko.git
    - Buat database baru dengan nama e-toko
    - Import database yang disediakan pada db/e-toko.sql
    - Aktifkan local server anda kemudian akses http://localhost:8000/login.php
    - Anda dapat login langsung dengan credentials
        - email: owner@contoh.com
        - password: bnsp123

## Cara Menggunakan

**Akses Halaman Login:**
   - Buka browser dan masukkan URL: http://localhost:8000/login.php.
   - Masukkan email dan password untuk login.

**CRUD Produk:**
   - Setelah login, Anda dapat mengelola produk melalui antarmuka yang tersedia.
   - Anda dapat menambah, mengedit, dan menghapus produk.

**Tambah Pengguna:**
   - Pengguna dapat ditambahkan melalui URL:http://localhost:8000/add-user.php ini hanya agar lebih cepat test user 
