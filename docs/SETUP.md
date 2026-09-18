# Panduan teknis AmbaRead Web

[Kembali ke ringkasan produk](../README.md)

## Lingkungan web

- Server web dengan PHP dan ekstensi MySQLi.
- MySQL atau MariaDB dengan skema aplikasi.
- Konfigurasi koneksi lokal pada `koneksi.php`.

## Menjalankan salinan lokal

1. Tempatkan source web pada server PHP lokal.
2. Siapkan skema database sesuai instalasi aplikasi.
3. Sesuaikan konfigurasi koneksi dalam salinan lokal.
4. Siapkan direktori upload jika ingin menguji unggahan.
5. Buka `landingpage.php` atau `login.php`.

Folder `ambaread/` dalam repo memuat berkas data database, bukan migrasi SQL yang siap diimpor. Reproduksi instalasi lengkap memerlukan skema database yang sesuai; jangan memperlakukan folder tersebut sebagai paket instalasi otomatis.

## Bagian mobile

Implementasi Flutter tersedia pada repo yang ditautkan di [halaman utama](../README.md#repositori-dalam-paket-ambaread). Masing-masing memiliki source pada `lib/` dan dependensi pada `pubspec.yaml`.

Web memakai database untuk akun, buku, dan favorit. Implementasi mobile memiliki model dan state sendiri; dokumentasi tidak mengasumsikan sinkronisasi penuh dengan web.
