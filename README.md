# Web Vulnerability - Sistem Autentikasi Pengguna Sederhana

Sistem autentikasi pengguna sederhana ini dikembangkan dengan **PHP** dan **MySQL** untuk tujuan edukasi dalam memahami kerentanan **SQL Injection**. Aplikasi ini mencakup:

1. Dashboard Admin untuk mengelola pengguna.
2. Halaman Profil Pengguna.
3. Fitur Topup dan Transfer Saldo.
4. Fitur Chat

> **Peringatan**: Aplikasi ini sengaja dibuat rentan terhadap SQL Injection untuk tujuan pembelajaran. Jangan gunakan di lingkungan produksi.

---

## Fitur Utama

### 1. Halaman Login

Pengguna dapat melakukan autentikasi menggunakan username dan password.

- **URL**: `/Views/login.php`

### 2. Dashboard Admin

Menu ini memungkinkan admin untuk:

- Mengelola data pengguna.
- Melihat aktivitas terbaru pengguna.

**Path**: `/Views/dashboard/index.php`

### 3. Profil Pengguna

Setiap pengguna dapat melihat informasi pribadi mereka seperti:

- Nama
- Username
- Email
- Alamat
- Saldo

**Path**: `/Views/users/profile.php`

### 4. Fitur Topup

Pengguna dapat melakukan topup saldo melalui halaman khusus.

- **URL**: `/Views/users/payment/topup.php`

### 5. Fitur Transfer

Pengguna dapat melakukan transfer saldo ke pengguna lain.

- **URL**: `/Views/users/payment/transfer.php`

### 6. Fitur Chat

Pengguna dapat dapat mengirim pesan chat ke pengguna lain.

- **URL**: `/Views/users/chat.php`

---

## Instalasi di Linux

### 1. Clone Repository

```bash
git clone https://github.com/Aryamahesa/Web_Vulnerbility.git
cd Web_Vulnerbility
mv Onion /var/www/html/
```

### 2. Setup Apache Virtual Host

```bash
sudo nano /etc/apache2/sites-available/onion.conf
```

Tambahkan konfigurasi berikut:

```apache
<VirtualHost *:80>
    ServerName example.com
    DocumentRoot /var/www/html/Onion

    <Directory /var/www/html/Onion>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/simple-auth-error.log
    CustomLog ${APACHE_LOG_DIR}/simple-auth-access.log combined
</VirtualHost>
```

Aktifkan virtual host dan restart Apache:

```bash
sudo a2ensite onion.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 3. Setup Database
1. Pastikan MySQL sudah terinstal di sistem Anda.
2. Import file backup_db.sql ke MySQL:

Jalankan perintah berikut di terminal:

```bash
mysql -u root -p < /path/to/backup_db.sql
```
Gantilah /path/to/backup_db.sql dengan path ke file yang Anda miliki.
3. Verifikasi Database:

Masuk ke MySQL untuk memeriksa apakah database dan tabel telah dibuat dengan benar:
```bash
mysql -u root -p
```

Setelah masuk, gunakan nama database yang telah dibuat (misalnya yourDB):
```bash
use socDB;
show TABLES;
```

Anda seharusnya melihat daftar tabel seperti:
- users
- topup
- transfer
- chat

4. Konfigurasikan Aplikasi:
Perbarui file connect.php dengan kredensial yang sesuai, seperti: 
```php
<?php
    $host = "localhost";
    $userConfig = "soc"; // Ganti dengan nama user di backup_db.sql
    $password = "soc123"; // Ganti dengan password user di backup_db.sql
    $dbName = "socDB"; // Nama database yang dibuat

    $conn = new mysqli($host, $userConfig, $password, $dbName);

    if ($conn -> connect_error){
        die ("Koneksi gagal : " . $conn -> connect_error);
    }
?>
```


### 4. Jalankan Aplikasi

1. Hubungkan database di `connect.php`.
2. Akses aplikasi melalui browser:
   - **Login**: `http://localhost/Views/login.php`
   - **Admin Dashboard**: `http://localhost/Views/dashboard/index.php`
   - **Profil Pengguna**: `http://localhost/Views/users/profile.php`

---

## Screenshot Menu

### 1. Halaman Login
![Login Page](/img/login-page.png)

### 2. Dashboard Admin
![Dashboard Admin](/img/dashboard-information.png)


![Dashboard Admin](/img/users-data.png)


![Dashboard Admin](/img/users-chat-history.png)


![Dashboard Admin](/img/users-transfer-history.png)


![Dashboard Admin](/img/users-topup-history.png)

### 3. Profil Pengguna
![Profile Page](/img/profile-page.png)

### 4. Fitur Topup & Fitur Transfer
![Transaction Page](/img/transaction-page.png)

### 4. Fitur Chat
![Transaction Page](/img/chat-page.png)

---

## Catatan Penting

1. Aplikasi ini **rentan terhadap SQL Injection** untuk tujuan edukasi.
2. Jangan gunakan aplikasi ini di lingkungan produksi.
3. Ubah file `/config/connect.php` untuk konfigurasi database sesuai kebutuhan.

---

## Kontak

Jika ada pertanyaan atau kontribusi:

- **Email**: [aryamhsa23@gmail.com](mailto\:aryamhsa23@gmail.com)
- **GitHub**: [Aryamahesa](https://github.com/Aryamahesa)

