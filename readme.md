# EasyHRIS

EasyHRIS adalah Human Resources Information System (HRIS) yang dapat digunakan untuk membantu memudahkan tugas HRD Perusahaan.

## Tahap Pengembangan

EasyHRIS belum dapat digunakan untuk produksi dan sedang dalam proses pengembangan.

## Minimum Requirement

- [x] PHP versi 7.2.1 dan extension yang diperlukan selama instalasi menggunakan composer
- [x] Mysql Database minimal versi 8
- [x] Web Server (Apache, Nginx atau IIS)

**NOTE**:

- [x] Sistem ini dikembangkan menggunakan lingkungan pengembangan Linux, pengembang tidak menjamin jika sistem ini dapat berjalan dengan baik pada sistem operasi lain.
- [x] Walaupun dapat berjalan pada DB Engine lain selain MySQL, namun sistem ini hanya mensupport untuk database MySQL.

## Fitur

- [x] Manajemen Perusahaan
- [x] Support Multi Perusahaan
- [x] Manajemen Jabatan
- [x] Manajemen Karyawan
- [x] Support Penempatan Karyawan
- [x] Manajemen Kontrak Kerja
- [x] Manajemen Kontrak Perusahaan dengan Rekanan/Klien
- [x] Karir History
- [x] Promosi, Mutasi, dan Demosi
- [x] Manajemen Shift Kerja
- [x] Manajemen Jadwal Kerja
- [x] Manajemen Absensi dengan fitur _rules_
- [x] Manajemen Hari Libur
- [x] Manajemen dan Perhitungan Lembur
- [x] Manajemen BPJS Kesehatan
- [x] Manajemen dan Perhitungan BPJS
- [x] Pajak PPH21 sesuai
- [x] Gaji
- [x] Laporan Penggajian
- [x] Laporan Beban Gaji Perusahaan
- [x] Historikal Data Karyawan (Jenjang Karir, Gaji, Tunjangan, dan Pajak)
- [x] Backend Site
- [x] Soft Delete (data tidak benar-benar dihapus)
- [x] Restore Deleted Record
- [x] Log Activity User untuk proses transaksi

## Cara Install (Manual)

- [x] Clone/Download repository `git clone https://github.com/pandigresik/EasyHRIS.git` dan pindah ke folder `EasyHRIS`
- [x] Jalankan [Composer](https://getcomposer.org/download) Install/Update `composer update`
- [x] Setup koneksi database pada config/database.php
- [x] Jalankan perintah `php -S <HOST>:<PORT>` untuk mengaktifkan web server local ( kebutuhan development )
- [x] Buka halaman `<HOST>:<PORT>/`

## Kontributor

Proyek ini dikembangkan oleh [Ahmad Afandi](https://github.com/ppandigresik) dan para [kontributor](https://github.com/pandigresik/EasyHRIS/graphs/contributors).

## TODO

Untuk apa saja yang sudah dan belum dikerjakan bisa melihat [TODO LIST](TODO.md)

## ROADMAP

Untuk mengetahui roadmap dari aplikasi EasyHRIS bisa melihat [ROADMAP](ROADMAP.md)

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://tldrlegal.com/license/mit-license) &copy; Ahmad Afandi.
Pastikan Anda memahami kewajiban dan hak Anda sebelum Anda memutuskan untuk menggunakan software ini.

## Donasi

Untuk mensupport proyek ini, Anda dapat memberikan donasi melalui rekening berikut:

## Profesional Support

Bila Anda memerlukan profesional support atau ingin mengadakan kerjasama dengan saya, dapat menghubungi saya melalui:

- Email: [ahmad.afandi85@gmail.com](mailto:ahmad.afandi85@gmail.com)
- WA: 0857-3365-9400
- FB: [Pandigresik](https://facebook.com/pandi.cerme)

## Keamanan Aplikasi

Jika Anda menemukan bug/celah keamaan pada aplikasi ini, Anda dapat mengirimkan email dengan subject: **[EasyHRIS][security] SUBJECT** ke alamat [ahmad.afandi85@gmail.com](mailto:ahmad.afandi85@gmail.com)

## Preview

![EasyHRIS Profil Karyawan Preview](preview/preview.png)

![EasyHRIS Laporan Absensi Preview](preview/preview2.png)

![EasyHRIS Detail Gaji](preview/penggajian3.png)

![EasyHRIS API Preview](preview/api-preview.png)

Butuh lebih banyak screenshot? silahkan cek folder [preview](preview)
