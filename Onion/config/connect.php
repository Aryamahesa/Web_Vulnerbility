<?php
$host = "localhost";
$username = "soc";
$password = "soc123";
$dbName = "socDB";

$conn = new mysqli($host, $username, $password, $dbName);

if ($conn -> connect_error){
    die ("Koneksi gagal : " . $conn -> connect_error);
}
    
?>