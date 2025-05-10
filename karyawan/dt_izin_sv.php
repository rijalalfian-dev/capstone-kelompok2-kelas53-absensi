<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['idsi']) || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    error_log("CSRF Debug: idsi=" . (isset($_SESSION['idsi']) ? $_SESSION['idsi'] : 'unset') . 
              ", POST_csrf=" . (isset($_POST['csrf_token']) ? $_POST['csrf_token'] : 'unset') . 
              ", SESSION_csrf=" . (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : 'unset'));
    header("Location: login_karyawan.php?error=Invalid request");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_karyawan = filter_input(INPUT_POST, 'id_karyawan', FILTER_VALIDATE_INT);
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $jenis_izin = filter_input(INPUT_POST, 'jenis_izin', FILTER_SANITIZE_STRING);
    $koordinasi = filter_input(INPUT_POST, 'koordinasi', FILTER_SANITIZE_STRING);
    $alasan = filter_input(INPUT_POST, 'alasan', FILTER_SANITIZE_STRING);
    $tanggal_mulai = filter_input(INPUT_POST, 'tanggal_mulai', FILTER_SANITIZE_STRING);
    $tanggal_selesai = filter_input(INPUT_POST, 'tanggal_selesai', FILTER_SANITIZE_STRING);

    if (!$id_karyawan || !$nama || !$jenis_izin || !$tanggal_mulai || !$tanggal_selesai) {
        header("Location: awal.php?error=Data tidak lengkap");
        exit;
    }

    $dokumen = null;
    if ($jenis_izin === 'sakit' && isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['dokumen'];
        $valid_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $max_size = 5 * 1024 * 1024; // 5MB
        if (!in_array($file['type'], $valid_types)) {
            header("Location: awal.php?error=File harus JPG, JPEG, PNG, atau PDF");
            exit;
        }
        if ($file['size'] > $max_size) {
            header("Location: awal.php?error=Ukuran file maksimum 5MB");
            exit;
        }
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_name = uniqid() . '_' . basename($file['name']);
        $file_path = $upload_dir . $file_name;
        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            header("Location: awal.php?error=Gagal mengunggah file");
            exit;
        }
        $dokumen = $file_path;
    }

    if (in_array($jenis_izin, ['libur_terjadwal', 'cuti', 'alasan_lain']) && empty($koordinasi)) {
        header("Location: awal.php?error=Koordinasi wajib diisi");
        exit;
    }
    if ($jenis_izin === 'alasan_lain' && empty($alasan)) {
        header("Location: awal.php?error=Alasan wajib diisi");
        exit;
    }

    try {
        $stmt = $koneksi->prepare("INSERT INTO tb_izin (id_karyawan, nama, jenis_izin, dokumen, koordinasi, alasan, tanggal_mulai, tanggal_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $id_karyawan, $nama, $jenis_izin, $dokumen, $koordinasi, $alasan, $tanggal_mulai, $tanggal_selesai);
        $stmt->execute();
        $stmt->close();
        header("Location: awal.php?success=Izin berhasil diajukan");
    } catch (Exception $e) {
        header("Location: awal.php?error=Gagal mengajukan izin: " . $e->getMessage());
    }
}

exit;
?>