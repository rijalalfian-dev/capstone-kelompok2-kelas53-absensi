<?php
session_start();
include("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Informasi Karyawan - Home</title>
  <link rel="icon" href="img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="vendors/linericon/style.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700" rel="stylesheet">
</head>
<body>
  <div id="vanta-bg"></div>
  <div id="loading-overlay">
    <img src="img/Fevicon.png" alt="Loading" class="loading-logo">
  </div>

  <header class="header_area">
    <div class="container box_1620">
      <h1>Aplikasi Absensi Karyawan</h1>
      <h2>Group 2, Kelas STSI4401.53</h2>
    </div>
  </header>

  <main class="site-main">
    <section class="section-margin">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-banner__img">
              <img class="img-fluid" src="img/logokaryawan.png" alt="Logo Karyawan">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-banner__content" id="login">
              <h1>Tentang Website Ini</h1>
              <p>Website ini berfungsi sebagai absensi karyawan dan sebagai sistem informasi karyawan perusahaan Kelompok 2 STSI4401.53 Co. Ltd.</p>
              <h1 class="smaller">Login Sebagai</h1>
              <div class="button-container">
                <a href="login.php" class="btn-custom">Login Admin</a>
                <a href="karyawan/login_karyawan.php" class="btn-custom">Login Karyawan</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer-area section-gap">
    <div class="container">
      <div class="footer-bottom row align-items-center text-center">
        <p class="footer-text m-0 col-12">
          Copyright © <?php echo date('Y'); ?> Kelompok 2, Kelas 53 - All rights reserved
        </p>
      </div>
    </div>
  </footer>

  <div id="theme-toggle" class="theme-toggle">
    <label class="switch">
      <input type="checkbox" id="theme-checkbox">
      <span class="slider"></span>
    </label>
  </div>

  <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
  <script>
    (function($) {
      "use strict";

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
        $('a').on('click', function(e) {
          const href = $(this).attr('href');
          if (href && href !== '#' && href !== '') {
            e.preventDefault();
            body.classList.add('blurring');
            $('#loading-overlay').addClass('visible');
            setTimeout(() => window.location.href = href, 600);
          }
        });
      });

    })(jQuery);
  </script>
</body>
</html>