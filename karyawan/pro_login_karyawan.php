<?php
session_start();

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start output buffering to prevent headers-already-sent errors
ob_start();

// Include database connection
require_once '../koneksi.php';

// Check database connection
if (!$koneksi) {
    error_log("Database connection failed: " . mysqli_connect_error());
    header("Location: login_karyawan.php?error=Koneksi database gagal");
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_karyawan.php?error=Akses tidak sah");
    exit;
}

// Capture and validate form data
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    header("Location: login_karyawan.php?error=Username dan password harus diisi");
    exit;
}

// Prepare query
$stmt = $koneksi->prepare("SELECT id_karyawan, username, nama, password FROM tb_karyawan WHERE username = ?");
if (!$stmt) {
    error_log("Prepare failed: " . $koneksi->error);
    header("Location: login_karyawan.php?error=Database error: Tidak dapat menyiapkan query");
    exit;
}

$stmt->bind_param("s", $username);
if (!$stmt->execute()) {
    error_log("Execute failed: " . $stmt->error);
    header("Location: login_karyawan.php?error=Database error: Eksekusi query gagal");
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    error_log("Get result failed: " . $stmt->error);
    header("Location: login_karyawan.php?error=Database error: Tidak dapat mengambil hasil");
    exit;
}

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    // Hash input password with MD5 to match database
    $hashed_password = md5($password);
    
    if ($data['password'] === $hashed_password) {
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Set session variables to match awal.php
        $_SESSION['idsi'] = $data['id_karyawan'];
        $_SESSION['namasi'] = $data['nama'];
        $_SESSION['username'] = $data['username']; // Optional
        
        // Redirect to awal.php
        header("Location: awal.php");
        exit;
    } else {
        header("Location: login_karyawan.php?error=Username atau password salah");
        exit;
    }
} else {
    header("Location: login_karyawan.php?error=Username atau password salah");
    exit;
}

$stmt->close();
$koneksi->close();

// Flush output buffer
ob_end_flush();
?>