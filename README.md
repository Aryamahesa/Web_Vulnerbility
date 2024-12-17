# Web Vulnerability - Sistem Autentikasi Pengguna Sederhana

Sistem autentikasi pengguna sederhana ini dikembangkan dengan **PHP** dan **MySQL** untuk tujuan edukasi dalam memahami kerentanan **SQL Injection**. Aplikasi ini mencakup:

1. Dashboard Admin untuk mengelola pengguna.
2. Halaman Profil Pengguna.
3. Fitur Topup dan Transfer Saldo.

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

**Path**: `/Views/dashboard/admin.php`

### 3. Profil Pengguna

Setiap pengguna dapat melihat informasi pribadi mereka seperti:

- Nama
- Username
- Email
- Alamat

**Path**: `/Views/users/profile.php`

### 4. Fitur Topup

Pengguna dapat melakukan topup saldo melalui halaman khusus.

- **URL**: `/Views/users/payment/topup.php`

### 5. Fitur Transfer

Pengguna dapat melakukan transfer saldo ke pengguna lain.

- **URL**: `/Views/users/payment/transfer.php`

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
sudo nano /etc/apache2/sites-available/your_configuration.conf
```

Tambahkan konfigurasi berikut:

```apache
<VirtualHost *:80>
    ServerName example.com
    DocumentRoot /path/to/direktori

    <Directory /path/to/direktori>
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
sudo a2ensite your_configuration.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 3. Setup Database

```bash
mysql -u root -p
```

Jalankan query berikut:

```sql
CREATE DATABASE yourDB;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON yourDB.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
exit;
```

Koneksikan database dan buat tabel:

```bash
mysql -u user -p
```

```sql
USE yourDB;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    balance DECIMAL(15,2) DEFAULT 0.00
);

CREATE TABLE topup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount INT,
    created_at DATETIME DEFAULT current_timestamp(),
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE transfer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    amount INT,
    created_at DATETIME DEFAULT current_timestamp(),
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);
```

### 4. Jalankan Aplikasi

1. Hubungkan database di `connect.php`.
2. Akses aplikasi melalui browser:
   - **Login**: `http://localhost/Views/login.php`
   - **Admin Dashboard**: `http://localhost/Views/dashboard/admin.php`
   - **Profil Pengguna**: `http://localhost/Views/users/profile.php`

---

## Screenshot Menu

### 1. Halaman Login
![Login Page](/img/login-page.png)

### 2. Dashboard Admin
![Dashboard Admin](/img/data-users.png)


![Dashboard Admin](/img/status-users.png)

### 3. Profil Pengguna
![Profile Page](/img/profile-page.png)

### 4. Fitur Topup & Fitur Transfer
![Transaction Page](/img/transaction-page.png)



---

## Catatan Penting

1. Aplikasi ini **rentan terhadap SQL Injection** untuk tujuan edukasi.
2. Jangan gunakan aplikasi ini di lingkungan produksi.
3. Ubah file `connect.php` untuk konfigurasi database sesuai kebutuhan.

---

## Kontak

Jika ada pertanyaan atau kontribusi:

- **Email**: [aryamhsa23@gmail.com](mailto\:aryamhsa23@gmail.com.com)
- **GitHub**: [Aryamahesa](https://github.com/Aryamahesa)

