# Star Bank - Banking Saving System

Star Bank adalah aplikasi sistem perbankan sederhana yang dibangun menggunakan **Laravel 11** sebagai Backend API dan **React.js** sebagai Frontend. Aplikasi ini mendukung manajemen data nasabah oleh Admin dan simulasi transaksi (Deposit & Withdraw) dengan perhitungan bunga otomatis untuk Customer.

## Fitur Utama

### Login
* **Password:** Untuk password login diisi dengan PIN.

### Admin Panel
* **Manajemen Customer:** Tambah, Edit, Hapus, dan Cari data nasabah (PIN wajib 6 digit).
* **Manajemen Akun:** Membuat rekening baru untuk nasabah dengan berbagai tipe deposito.
* **Tipe Deposito:** Pengaturan bunga tahunan (Bronze 3%, Silver 5%, Gold 7%).
* **Fitur Cari:** Pencarian data di semua menu secara real-time.

### Customer Dashboard
* **Kartu Saldo:** Informasi saldo efektif dan bunga yang didapat.
* **Setor Dana (Deposit):** Menambah saldo dengan catatan tanggal transaksi.
* **Tarik Dana (Withdraw):** Simulasi penarikan yang otomatis menghitung bunga bulanan ($Ending Balance = Balance + Interest - Amount$).
* **Riwayat Transaksi:** Laporan mutasi masuk dan keluar yang rapi.

## 🛠️ Tech Stack

* **Backend:** PHP 8.x, Laravel 11, MySQL
* **Frontend:** React.js, Axios, React Router Dom
* **Security:** Database Transaction (Rollback system) untuk integritas saldo nasabah.

## ⚙️ Cara Instalasi

### Backend (Laravel)
1. Clone repository ini.
2. Jalankan `composer install`.
3. Copy `.env.example` menjadi `.env` dan sesuaikan koneksi database.
4. Jalankan `php artisan migrate --seed`.
5. Jalankan server: `php artisan serve`.

### Frontend (React)
1. Buka folder frontend.
2. Jalankan `npm install`.
3. Jalankan aplikasi: `npm run dev`.

## Aturan Bisnis (Business Rules)
1. PIN Nasabah harus tepat **6 Karakter**.
2. Minimal Penarikan/Setoran adalah **Rp 10.000**.
3. Bunga dihitung per bulan berdasarkan bunga tahunan tipe deposito yang dipilih.
4. Sistem menggunakan **Database Transaction**; jika pencatatan riwayat gagal, saldo tidak akan terpotong.

