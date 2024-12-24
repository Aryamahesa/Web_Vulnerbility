<?php
$host = "localhost";
$userConfig = "soc";
$password = "soc123";
$dbName = "socDB";

$conn = new mysqli($host, $userConfig, $password, $dbName);

if ($conn -> connect_error){
    die ("Koneksi gagal : " . $conn -> connect_error);
}
    
?>