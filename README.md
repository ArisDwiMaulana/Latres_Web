# Aplikasi Katalog Kue (Toko Roti)

Dalam pengerjaan latihan ini, saya menggunakan **Docker** karena di perangkat yang saya gunakan saat ini tidak terpasang XAMPP. 
Tetapi dapat dijalankan dengan **2 cara berbeda** (Docker Compose maupun XAMPP) tanpa perlu mengubah konfigurasi database di file `koneksi.php`.

## Cara Menjalankan Aplikasi

### 1. Menggunakan Docker Compose
1. Clone repository ini dan masuk ke direktori proyek:
   ```bash
   git clone https://github.com/ArisDwiMaulana/Latres_Web.git
   cd Latres_Web/
   ```
2. Jalankan perintah berikut:
   ```bash
   docker compose up -d
   ```
3. Buka phpMyAdmin di `http://localhost:8080`, lalu masukkan kredensial:
   * **Server:** `db`
   * **Username:** `root`
   * **Password:** *(dikosongkan)*
4. Buat database baru bernama `toko_roti`, lalu impor file `.sql` nya.
5. Akses aplikasi melalui browser di `http://localhost/login.php`.

### 2. Menggunakan XAMPP
1. Clone atau pindahkan repository ini ke dalam folder `htdocs` XAMPP.
2. Jalankan modul **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Buat database baru bernama `toko_roti` di `http://localhost/phpmyadmin`, lalu impor file `.sql` yang tersedia.
4. Akses aplikasi melalui browser di `http://localhost/toko_roti/login.php` *(sesuaikan `toko_roti` dengan nama folder di dalam `htdocs`)*.