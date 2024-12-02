# Web_Vulnerbility

Sistem Autentikasi Pengguna Sederhana
Sebuah sistem autentikasi pengguna sederhana yang dibuat dengan PHP dan MySQL, dirancang untuk tujuan edukasi. Aplikasi ini mencakup:

Dashboard Admin untuk mengelola pengguna
Halaman Profil Pengguna
Rentan terhadap SQL Injection (untuk kebutuhan pengujian lab)
Persyaratan
- Server Apache
- PHP >= 7.4
- MySQL
- Git

## Linux Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/Aryamahesa/Web_Vulnerbility.git
cd Web_Vulnerbility
mv Onion /var/www/html/
```
### 2. Setup Apache Virtual Host
```bash
sudo nano /etc/apache2/sites-available/your_configuratioin.conf
```
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
```bash
sudo a2ensite your_configuration.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```
### 3. Setup Database
```bash
mysql -u root -p
```
```sql
CREATE DATABASE yourDB;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'user';
GRANT ALL PRIVILEGES ON userDB.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
exit;
```
```bash
mysql -u user -p
```

```sql
use yourDB;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);
```
- masukan data sesuai table diatas
  
### 4. Pengujian Aplikasi
2. Hubungkan dengan database di `http://localhost/connect.php`
2. Akses aplikasi di `http://localhost`. 
4. Uji peran admin dan pengguna:
    - Dashboard Admin: `/dashboard/admin.php`
    - Profil Pengguna: `/users/profile.php`

# Note!!
Aplikasi ini sengaja rentan terhadap SQL Injection untuk tujuan pendidikan. Jangan gunakan ini di lingkungan produksi.
Ubah connect.php atau pengaturan basis data sesuai kebutuhan untuk lingkungan Anda.




