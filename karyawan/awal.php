<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['idsi']) || !isset($_SESSION['namasi'])) {
    header("Location: login_karyawan.php");
    exit;
}

// Generate and store CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

require_once '../koneksi.php';
$id = $_SESSION['idsi'];
$stmt = $koneksi->prepare("SELECT nama, foto FROM tb_karyawan WHERE id_karyawan = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$r = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Karyawan - Sistem Informasi Karyawan</title>
    <link rel="icon" href="../img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="../vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body class="awal-page">
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="../img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <!-- Notification Modal -->
    <?php if (isset($_GET['success']) || isset($_GET['error'])): ?>
        <div class="modal-overlay show" id="notification-modal">
            <div class="modal-content <?php echo isset($_GET['success']) ? '' : 'error'; ?>">
                <span class="modal-close">×</span>
                <h3><?php echo isset($_GET['success']) ? 'Berhasil' : 'Gagal'; ?></h3>
                <p><?php echo isset($_GET['success']) ? htmlspecialchars($_GET['success']) : htmlspecialchars($_GET['error']); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <header class="header_area">
        <div class="container">
            <h1>Aplikasi Absensi Karyawan</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($r['nama']); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="admin-container">
                    <div class="admin-header">
                        <h1>Beranda Karyawan</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Navigasi</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><a href="awal.php" class="d-block py-2 text-primary"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                                        <li><a href="profil.php" class="d-block py-2"><i class="fas fa-user mr-2"></i> Profil</a></li>
                                        <li><a href="logout.php" class="d-block py-2 text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Absen Karyawan</h5>
                                </div>
                                <div class="card-body">
                                    <form action="dt_absen_sv.php" method="post" id="absen-form">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="jenis_absen" id="jenis_absen">
                                        <div class="form-group">
                                            <label for="id_karyawan">NIP</label>
                                            <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" value="<?php echo htmlspecialchars($_SESSION['idsi']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($_SESSION['namasi']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="waktu">Waktu</label>
                                            <input type="text" class="form-control" id="waktu" name="waktu" value="<?php echo date('l, d-m-Y h:i:s a'); ?>" readonly>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary absen-btn" data-jenis="masuk">Absen Masuk</button>
                                            <button type="button" class="btn btn-primary absen-btn" data-jenis="pulang">Absen Pulang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Izin Libur</h5>
                                </div>
                                <div class="card-body">
                                    <form action="dt_izin_sv.php" method="post" enctype="multipart/form-data" id="izin-form">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <div class="form-group">
                                            <label for="id_karyawan">NIP</label>
                                            <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" value="<?php echo htmlspecialchars($_SESSION['idsi']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($_SESSION['namasi']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_izin">Jenis Izin</label>
                                            <select class="form-control" id="jenis_izin" name="jenis_izin" required>
                                                <option value="">Pilih Jenis Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="libur_terjadwal">Libur Terjadwal</option>
                                                <option value="cuti">Cuti</option>
                                                <option value="alasan_lain">Alasan Lain</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="dokumen-group" style="display: none;">
                                            <label for="dokumen">Surat Keterangan Dokter (JPG, JPEG, PNG, PDF)</label>
                                            <input type="file" class="form-control-file" id="dokumen" name="dokumen" accept=".jpg,.jpeg,.png,.pdf">
                                        </div>
                                        <div class="form-group" id="koordinasi-group" style="display: none;">
                                            <label for="koordinasi">Koordinasi Dengan (Nama, wajib diisi)</label>
                                            <textarea class="form-control" id="koordinasi" name="koordinasi" rows="3"></textarea>
                                        </div>
                                        <div class="form-group" id="alasan-group" style="display: none;">
                                            <label for="alasan">Alasan</label>
                                            <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" name="simpan_izin" class="btn btn-primary">Ajukan Izin</button>
                                        </div>
                                    </form>
                                </div>
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

            // Show notification modal if present
            const modal = $('#notification-modal');
            if (modal.length) {
                modal.addClass('show');
            }

            // Close modal
            $('.modal-close').on('click', function() {
                modal.removeClass('show');
                setTimeout(() => modal.hide(), 300);
                window.history.replaceState({}, document.title, window.location.pathname);
            });

            // Close modal when clicking outside
            modal.on('click', function(e) {
                if (e.target === this) {
                    $('.modal-close').trigger('click');
                }
            });

            // Handle jenis_izin change for conditional fields
            $('#jenis_izin').on('change', function() {
                const value = $(this).val();
                $('#dokumen-group').toggle(value === 'sakit');
                $('#koordinasi-group').toggle(['libur_terjadwal', 'cuti', 'alasan_lain'].includes(value));
                $('#alasan-group').toggle(value === 'alasan_lain');
            });

            // Handle absen button clicks
            $('.absen-btn').on('click', function() {
                $('#jenis_absen').val($(this).data('jenis'));
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            $('#latitude').val(position.coords.latitude);
                            $('#longitude').val(position.coords.longitude);
                            $('#absen-form').submit();
                        },
                        (error) => {
                            alert('Gagal mendapatkan lokasi: ' + error.message);
                        }
                    );
                } else {
                    alert('Geolocation tidak didukung oleh browser Anda.');
                }
            });
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