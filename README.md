# Star Bank - Banking Saving System

Star Bank adalah aplikasi sistem perbankan sederhana yang dibangun menggunakan **Laravel 11** dengan arsitektur **Monolith (Blade Engine)**. Aplikasi ini dirancang untuk manajemen data nasabah oleh Admin dan simulasi transaksi perbankan dengan perhitungan bunga otomatis bagi Customer.

---

## Fitur Utama

### Autentikasi
*   **Multi-role Login:** Pengalihan halaman otomatis berdasarkan peran (Admin atau Customer).
*   **PIN Security:** Sistem login menggunakan Email dan 6-digit PIN.
*   **Show/Hide PIN:** Fitur keamanan pada form login untuk menyembunyikan atau menampilkan karakter password secara interaktif.

### Admin Panel (Manajemen Data)
*   **Manajemen Customer:** CRUD (Create, Read, Update, Delete) data customer secara lengkap.
*   **Manajemen Rekening:** Pembuatan nomor rekening unik (Account ID) untuk setiap customer.
*   **Tipe Deposito:** Pengaturan bunga tahunan yang fleksibel:
    *   **Bronze:** 3%
    *   **Silver:** 5%
    *   **Gold:** 7%
*   **Fitur Pencarian:** Sistem filter data nasabah dan rekening secara real-time.

### Customer Dashboard
*   **Digital Wallet UI:** Antarmuka kartu saldo modern dengan informasi saldo efektif dan tipe deposito.
*   **Setor Dana (Deposit):** Penambahan saldo instan dengan pencatatan riwayat transaksi otomatis.
*   **Tarik Dana (Withdraw):** Simulasi penarikan pintar yang menghitung bunga bulanan secara real-time sebelum transaksi dikonfirmasi.
*   **Riwayat Mutasi:** Laporan transaksi masuk dan keluar yang mendetail dengan indikator warna (Hijau/Merah).

---

## Tech Stack

*   **Framework:** Laravel 11
*   **Language:** PHP 8.x
*   **Database:** MySQL
*   **Frontend:** Blade Templating, JavaScript (Vanilla JS), CSS Custom (Inter Fonts)
*   **Keamanan:** Laravel Session, CSRF Protection, & Database Transactions (Atomic Operations).

---

## Cara Instalasi

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/username/star-bank.git](https://github.com/username/star-bank.git)
    cd star-bank
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment:**
    Salin file `.env.example` menjadi `.env` dan sesuaikan koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4.  **Migrate & Seed:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Aplikasi:**
    
```bash
    php artisan serve
    ```
    Buka `http://localhost:8000` di browser Anda.

---

## Aturan Bisnis (Business Rules)

1.  **Keamanan PIN:** PIN Nasabah wajib terdiri dari tepat **6 karakter**.
2.  **Limit Transaksi:** Minimal setoran atau penarikan adalah **Rp 10.000**.
3.  **Logika Bunga (Withdraw):** Bunga dihitung bulanan saat melakukan penarikan dengan rumus: 
    > $Saldo Akhir = Saldo Awal + (\frac{Saldo Awal \times (Bunga Tahunan / 100)}{12}) - Nominal Penarikan$
4.  **Integritas Data:** Implementasi **Database Transaction** memastikan jika salah satu proses (update saldo atau simpan riwayat) gagal, maka seluruh transaksi akan dibatalkan (*Rollback*).

---

## Akun Demo 

| Role | Email | PIN |
| :--- | :--- | :--- |
| **Admin** | admin1@gmail.com | 123456 |
| **Customer** | NUr000@example.com | 112233 |

---
Copyright © 2026 Star Bank Project