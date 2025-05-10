<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Karyawan - Sistem Informasi Karyawan</title>
    <link rel="icon" href="../img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="../vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body class="login-page">
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="../img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <header class="header_area">
        <div class="container">
            <h1>Aplikasi Absensi Karyawan</h1>
            <h2>Group 2, Kelas STSI4401.53</h2>
        </div>
    </header>

    <main class="site-main">
        <div class="main-w3layouts wrapper">
            <h1>Login Karyawan</h1>
            <div class="main-agileinfo">
                <div class="agileits-top">
                    <?php if (isset($_GET['error'])): ?>
                        <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php endif; ?>
                    <form action="pro_login_karyawan.php" method="post">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="submit" value="Login" class="btn btn-primary">
                    </form>
                    <div class="back-to-home text-center">
                        <a href="../index.php" class="btn btn-secondary">Kembali ke Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
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
            $('a').on('click', function(e) {
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