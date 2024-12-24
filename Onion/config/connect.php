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