<?php
$host = "localhost"; // Standard for cPanel
$username = "vmafixbj_rijalalf";
$password = "H#MBoP%K^6fk";
$database = "vmafixbj_capstonek253";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
?>