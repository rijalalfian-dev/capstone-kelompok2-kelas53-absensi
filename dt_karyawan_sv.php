<?php
session_start();
include __DIR__ . '/koneksi.php';

// Pastikan koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Periksa apakah form disubmit
if (!isset($_POST['simpan'])) {
    echo "<script>alert('Form tidak disubmit dengan benar.');window.location='datakaryawan.php';</script>";
    exit;
}

// Tangkap data dari form
$id_karyawan = $_POST['id_karyawan'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$nama = $_POST['nama'] ?? '';
$tmp_tgl_lahir = $_POST['tmp_tgl_lahir'] ?? '';
$jenkel = $_POST['jenkel'] ?? '';
$agama = $_POST['agama'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$no_tel = $_POST['no_tel'] ?? '';
$jabatan = $_POST['jabatan'] ?? '';

// Hash the password with MD5
$password = md5($password);

// Validasi input dasar
if (empty($id_karyawan) || empty($username) || empty($password) || empty($nama)) {
    echo "<script>alert('Harap isi semua kolom wajib.');window.location='datakaryawan.php';</script>";
    exit;
}

// Check for duplicate id_karyawan or username
$stmt = $koneksi->prepare("SELECT id_karyawan, username FROM tb_karyawan WHERE id_karyawan = ? OR username = ?");
$stmt->bind_param("ss", $id_karyawan, $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $error = $row['id_karyawan'] === $id_karyawan ? "NIP sudah digunakan." : "Username sudah digunakan.";
    echo "<script>alert('$error');window.location='datakaryawan.php';</script>";
    $stmt->close();
    exit;
}
$stmt->close();

// Handle file upload
$target_dir = "images/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}
$foto = $_FILES['foto']['name'] ?? '';
$tmp = $_FILES['foto']['tmp_name'] ?? '';
$imageFileType = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
$fotobaru = $foto ? date('dmYHis') . $foto : '';

// Validate file
if (empty($foto)) {
    echo "<script>alert('Foto harus diunggah.');window.location='datakaryawan.php';</script>";
    exit;
}

$check = getimagesize($tmp);
if ($check === false) {
    echo "<script>alert('File bukan gambar.');window.location='datakaryawan.php';</script>";
    exit;
}

if ($_FILES['foto']['size'] > 2000000) {
    echo "<script>alert('File terlalu besar (maks 2MB).');window.location='datakaryawan.php';</script>";
    exit;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "<script>alert('Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.');window.location='datakaryawan.php';</script>";
    exit;
}

$target_file = $target_dir . $fotobaru;
if (file_exists($target_file)) {
    echo "<script>alert('File sudah ada.');window.location='datakaryawan.php';</script>";
    exit;
}

if (!move_uploaded_file($tmp, $target_file)) {
    echo "<script>alert('Gagal mengunggah file.');window.location='datakaryawan.php';</script>";
    exit;
}

// Insert data with prepared statement
$stmt = $koneksi->prepare("INSERT INTO tb_karyawan (id_karyawan, username, password, nama, tmp_tgl_lahir, jenkel, agama, alamat, no_tel, jabatan, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $id_karyawan, $username, $password, $nama, $tmp_tgl_lahir, $jenkel, $agama, $alamat, $no_tel, $jabatan, $fotobaru);

if ($stmt->execute()) {
    echo "<script>alert('Data karyawan berhasil disimpan!');window.location='datakaryawan.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "');window.location='datakaryawan.php';</script>";
}

$stmt->close();
$koneksi->close();
?>