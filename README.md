# Sistem Apotek — Tim Apotek Sehat

Modul yang dikerjakan tim:
1. **Login** (admin & operator, role-based)
2. **Manajemen Obat** (id, kode, nama obat, kategori, status) + **Manajemen Kategori** (id, nama, status)
3. **Manajemen User** (username, password, role) — khusus admin

Dibangun dengan **PHP Native (PDO)** dan **Bootstrap 5** (via CDN, tanpa perlu npm/composer).

## Struktur Folder

```
apotek/
├── config/
│   ├── koneksi.example.php   # template konfigurasi (di-commit)
│   └── koneksi.php           # koneksi database (di-gitignore)
├── includes/
│   ├── auth.php               # fungsi cekLogin() & cekAdmin()
│   ├── header.php
│   └── footer.php
├── auth/
│   ├── login.php
│   └── logout.php
├── obat/                      # CRUD obat
├── kategori/                  # CRUD kategori
├── user/                      # CRUD user (khusus admin)
├── assets/
│   └── style.css
├── index.php                  # dashboard
└── db_apotek.sql              # skema + data awal
```

## Cara Instalasi (Laragon)

1. Clone repo ke folder `www` Laragon:
   ```
   git clone https://github.com/muhammadashari-29/apotek.git
   ```
2. Buka HeidiSQL/phpMyAdmin, import file `db_apotek.sql` (otomatis membuat database `db_apotek` beserta data awal).
3. Salin `config/koneksi.example.php` menjadi `config/koneksi.php`, sesuaikan `$user`/`$pass` jika MySQL kamu pakai password.
4. Jalankan Laragon (Start All), akses lewat browser: `http://apotek.test/auth/login.php`

## Akun Default

| Username  | Password    | Role     |
|-----------|-------------|----------|
| admin     | admin123    | admin    |
| operator1 | operator123 | operator |

> Password sudah di-hash dengan bcrypt (`password_hash`), **jangan** simpan password polos di database.

## Hak Akses (Role)

- **Admin**: akses penuh — dashboard, obat, kategori, dan manajemen user.
- **Operator**: akses dashboard, obat, dan kategori — **tidak bisa** akses menu Data User (kalau nekat akses URL-nya langsung, akan otomatis di-redirect ke dashboard dengan pesan akses ditolak).

Logika hak akses ada di `includes/auth.php` (fungsi `cekLogin()` dan `cekAdmin()`), gampang disesuaikan kalau pembagian aksesnya perlu diubah.

## Catatan Teknis

- Password di-hash pakai `password_hash()` / diverifikasi dengan `password_verify()`.
- Semua query pakai **prepared statement (PDO)** supaya aman dari SQL Injection.
- Semua output ke HTML di-`htmlspecialchars()` untuk mencegah XSS.
- Kode obat & username divalidasi unik sebelum insert/update.
- Kategori tidak bisa dihapus kalau masih dipakai oleh data obat (`ON DELETE CASCADE` di database).

## Tools yang Digunakan

- Laragon (Apache + MySQL)
- Bootstrap 5.3
- Git & GitHub
- Notepad++
- HeidiSQL / phpMyAdmin