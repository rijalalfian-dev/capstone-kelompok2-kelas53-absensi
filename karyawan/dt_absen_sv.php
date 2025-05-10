<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once '../koneksi.php';

// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: awal.php?error=Invalid CSRF token");
    exit;
}

// Sanitize input
$id_karyawan = filter_input(INPUT_POST, 'id_karyawan', FILTER_SANITIZE_NUMBER_INT);
$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
$waktu = filter_input(INPUT_POST, 'waktu', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$jenis_absen = filter_input(INPUT_POST, 'jenis_absen', FILTER_SANITIZE_STRING);

// Validate jenis_absen
if (!in_array($jenis_absen, ['masuk', 'pulang'])) {
    header("Location: awal.php?error=Invalid absen type");
    exit;
}

// Convert waktu to MySQL datetime format
$waktu = date('Y-m-d H:i:s', strtotime($waktu));

// Check for existing absen record for the same day and type
$today = date('Y-m-d');
$stmt_check = $koneksi->prepare("
    SELECT id_absen FROM tb_absen 
    WHERE id_karyawan = ? AND jenis_absen = ? AND DATE(waktu) = ?
");
$stmt_check->bind_param("iss", $id_karyawan, $jenis_absen, $today);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    $message = ($jenis_absen === 'masuk') ? 'Anda sudah absen masuk hari ini' : 'Anda sudah absen pulang hari ini';
    header("Location: awal.php?error=" . urlencode($message));
    $stmt_check->close();
    exit;
}
$stmt_check->close();

// Prepare and execute insert query
$stmt = $koneksi->prepare("
    INSERT INTO tb_absen (
        id_karyawan, nama, waktu, jenis_absen, 
        latitude_masuk, longitude_masuk, latitude_pulang, longitude_pulang
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

// Set geolocation based on jenis_absen
$latitude_masuk = $longitude_masuk = $latitude_pulang = $longitude_pulang = null;
if ($jenis_absen === 'masuk') {
    $latitude_masuk = $latitude;
    $longitude_masuk = $longitude;
} else {
    $latitude_pulang = $latitude;
    $longitude_pulang = $longitude;
}

$stmt->bind_param(
    "isssdddd",
    $id_karyawan,
    $nama,
    $waktu,
    $jenis_absen,
    $latitude_masuk,
    $longitude_masuk,
    $latitude_pulang,
    $longitude_pulang
);

if ($stmt->execute()) {
    $message = ($jenis_absen === 'masuk') ? 'Berhasil Absen Masuk' : 'Berhasil Absen Pulang';
    header("Location: awal.php?success=" . urlencode($message));
} else {
    header("Location: awal.php?error=Gagal menyimpan absensi: " . urlencode($stmt->error));
}

$stmt->close();
$koneksi->close();
?>