<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['idsi']) || !isset($_SESSION['namasi'])) {
    header("Location: login_karyawan.php");
    exit;
}

require_once '../koneksi.php';
$id = $_SESSION['idsi'];
$stmt = $koneksi->prepare("SELECT id_karyawan, username, nama, tmp_tgl_lahir, jenkel, agama, alamat, no_tel, jabatan, foto FROM tb_karyawan WHERE id_karyawan = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    header("Location: login_karyawan.php?error=Data karyawan tidak ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Karyawan - Sistem Informasi Karyawan</title>
    <link rel="icon" href="../img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="../vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body class="profile-page">
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="../img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <header class="header_area">
        <div class="container">
            <h1>Aplikasi Absensi Karyawan</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($employee['nama']); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="profile-container">
                    <div class="profile-header">
                        <h1>Profil Karyawan</h1>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Detail Profil</h5>
                        </div>
                        <div class="card-body">
                            <div class="profile-content">
                                <div class="profile-photo">
                                    <img src="<?php 
                                        echo ($employee['foto'] && file_exists("../Uploads/{$employee['foto']}")) 
                                            ? "../Uploads/" . htmlspecialchars($employee['foto']) 
                                            : "../images/foto_default.png"; 
                                    ?>" alt="Foto Profil" class="profile-img">
                                </div>
                                <table class="table table-bordered profile-table">
                                    <tbody>
                                        <tr>
                                            <th>NIP</th>
                                            <td><?php echo htmlspecialchars($employee['id_karyawan']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Username</th>
                                            <td><?php echo htmlspecialchars($employee['username']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <td><?php echo htmlspecialchars($employee['nama']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td><?php echo $employee['tmp_tgl_lahir'] === '0000-00-00' ? 'Tidak diatur' : htmlspecialchars($employee['tmp_tgl_lahir']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td><?php echo htmlspecialchars($employee['jenkel']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Agama</th>
                                            <td><?php echo htmlspecialchars($employee['agama']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td><?php echo htmlspecialchars($employee['alamat'] ?: 'Tidak diatur'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon</th>
                                            <td><?php echo htmlspecialchars($employee['no_tel']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            <td><?php echo htmlspecialchars($employee['jabatan'] ?: 'Tidak diatur'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="back-to-dashboard">
                                <a href="awal.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-area">
        <div class="container">
            <p class="footer-text m-0 text-center">
                Copyright © <?php echo date('Y'); ?> Rijal Alfian | All rights reserved
            </p>
        </div>
    </footer>

    <div class="theme-toggle">
        <label class="switch">
            <input type="checkbox" id="theme-checkbox">
            <span class="slider"></span>
        </label>
    </div>

    <script src="../vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script>
        let vantaEffect;
        const vantaEl = document.getElementById('vanta-bg');
        const checkbox = document.getElementById('theme-checkbox');
        const body = document.body;

        function initVanta(isLight) {
            try {
                if (vantaEffect) vantaEffect.destroy();
                vantaEffect = VANTA.GLOBE({
                    el: vantaEl,
                    mouseControls: true,
                    touchControls: true,
                    gyroControls: true,
                    minHeight: 200,
                    minWidth: 200,
                    scale: 0.7,
                    scaleMobile: 1,
                    color: isLight ? 0x1b1b82 : 0xffffff,
                    backgroundColor: isLight ? 0x756f7f : 0x111111,
                    size: 1.2
                });
            } catch (e) {
                console.error('Vanta.js Error:', e);
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (!vantaEl) {
                console.error('Vanta.js: Element #vanta-bg not found');
                return;
            }
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                body.classList.add('light-mode');
                checkbox.checked = true;
                initVanta(true);
            } else {
                initVanta(false);
            }
            setTimeout(() => body.classList.add('loaded'), 100);
            $('#loading-overlay').removeClass('visible');
        });

        checkbox.addEventListener('change', () => {
            body.classList.toggle('light-mode', checkbox.checked);
            localStorage.setItem('theme', checkbox.checked ? 'light' : 'dark');
            initVanta(checkbox.checked);
        });

        $(document).ready(() => {
            $('a').not('[href*="logout.php"]').on('click', function(e) {
                const href = $(this).attr('href');
                if (href && href !== '#' && href !== '') {
                    e.preventDefault();
                    $('#loading-overlay').addClass('visible');
                    setTimeout(() => window.location.href = href, 600);
                }
            });
        });
    </script>
</body>
</html>