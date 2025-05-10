<?php
session_start();
include_once "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Informasi Karyawan</title>
    <link rel="icon" href="./img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="./vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body class="admin-page">
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="./img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <header class="header_area">
        <div class="container">
            <h1>Dashboard Admin</h1>
            <h2>Selamat datang, <?php echo $username; ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 admin-container">
                        <div class="admin-header">
                            <h1>Selamat Datang di Halaman Administrator</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <i class="fas fa-users"></i>
                                    <h3>Data Karyawan</h3>
                                    <p>Kelola informasi karyawan</p>
                                    <a href="datakaryawan.php" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <i class="fas fa-user-cog"></i>
                                    <h3>Data User</h3>
                                    <p>Kelola akun pengguna admin</p>
                                    <a href="datauser.php" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <i class="fas fa-briefcase"></i>
                                    <h3>Data Jabatan</h3>
                                    <p>Atur daftar jabatan perusahaan</p>
                                    <a href="datajabatan.php" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <i class="fas fa-calendar-check"></i>
                                    <h3>Data Absensi</h3>
                                    <p>Pantau kehadiran karyawan</p>
                                    <a href="data_absen.php" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <i class="fas fa-file-alt"></i>
                                    <h3>Data Keterangan</h3>
                                    <p>Kelola informasi keterangan absensi</p>
                                    <a href="data_keterangan.php" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="logout-button">
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-area">
        <div class="container">
            <p class="footer-text m-0 text-center">
                Copyright © <?php echo date('Y'); ?> Kelompok 2, Kelas 53 - All rights reserved
            </p>
        </div>
    </footer>

    <div class="theme-toggle">
        <label class="switch">
            <input type="checkbox" id="theme-checkbox">
            <span class="slider"></span>
        </label>
    </div>

    <script src="./vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="./vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script>
        let vantaEffect;
        const vantaEl = document.getElementById('vanta-bg');
        const checkbox = document.getElementById('theme-checkbox');
        const body = document.body;

        function initVanta(isLight) {
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
            $('a').not('[href*="logout"]').on('click', function(e) {
                const href = $(this).attr('href');
                if (href && href !== '#' && href !== '') {
                    e.preventDefault();
                    body.classList.add('blurring');
                    $('#loading-overlay').addClass('visible');
                    setTimeout(() => window.location.href = href, 600);
                }
            });
        });
    </script>
</body>
</html>