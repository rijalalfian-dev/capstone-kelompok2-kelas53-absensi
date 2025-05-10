<?php
session_start();
include_once "koneksi.php";

// Check database connection
if (!$koneksi) {
    die("<script>alert('Database connection failed: " . mysqli_connect_error() . "'); window.location='login.php';</script>");
}

// Retrieve and sanitize POST data
$username = isset($_POST['username']) ? mysqli_real_escape_string($koneksi, $_POST['username']) : '';
$password = isset($_POST['password']) ? mysqli_real_escape_string($koneksi, $_POST['password']) : '';

// Query to check credentials
$sql = "SELECT * FROM tb_daftar WHERE username='$username'";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("<script>alert('Query failed: " . mysqli_error($koneksi) . "'); window.location='login.php';</script>");
}

$hasil = mysqli_fetch_assoc($query);

if ($query->num_rows == 0) {
    echo "<script>alert('Username not registered.'); window.location='login.php';</script>";
} else {
    // Note: Plaintext password comparison is insecure; consider upgrading to password_hash/password_verify
    if ($password !== $hasil['password']) {
        echo "<script>alert('Incorrect password.'); window.location='login.php';</script>";
    } else {
        $_SESSION['username'] = $hasil['username'];
        header('Location: admin2.php');
        exit();
    }
}
?>