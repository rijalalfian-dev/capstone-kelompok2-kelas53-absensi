<?php
session_start();
include_once "koneksi.php";

if (!isset($_SESSION['idsi'])) {
    header("Location: karyawan/login_karyawan.php");
    exit;
}

$id_karyawan = $_SESSION['idsi'];
$employee = $koneksi->query("SELECT nama, jabatan FROM tb_karyawan WHERE id_karyawan = $id_karyawan")->fetch_assoc();

if ($employee['jabatan'] !== 'PM') {
    header("Location: karyawan/awal.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_izin = $_POST['id_izin'];
    $action = $_POST['action'];
    $status = $action === 'approve' ? 'Approved' : 'Rejected';
    
    $stmt = $koneksi->prepare("UPDATE tb_izin SET status = ?, approved_by = ?, approved_at = NOW() WHERE id_izin = ?");
    $stmt->bind_param("sii", $status, $id_karyawan, $id_izin);
    if ($stmt->execute()) {
        $success = "Permintaan telah $status.";
    } else {
        $error = "Gagal memproses permintaan.";
    }
    $stmt->close();
}

$query = "
    SELECT i.id_izin, k.nama, i.tanggal, i.alasan, i.keterangan
    FROM tb_izin i
    JOIN tb_karyawan k ON i.id_karyawan = k.id_karyawan
    WHERE i.status = 'Pending'
    ORDER BY i.tanggal DESC
";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval PM - Sistem Informasi Karyawan</title>
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
            <h1>Approval PM</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($employee['nama']); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="admin-container">
                    <div class="admin-header">
                        <h1>Daftar Permintaan Izin</h1>
                    </div>
                    <?php if (isset($success)) { ?>
                        <div class="modal-overlay show" id="success-modal">
                            <div class="modal-content">
                                <span class="modal-close">&times;</span>
                                <h3>Sukses</h3>
                                <p><?php echo $success; ?></p>
                            </div>
                        </div>
                    <?php } elseif (isset($error)) { ?>
                        <div class="modal-overlay show" id="error-modal">
                            <div class="modal-content error">
                                <span class="modal-close">&times;</span>
                                <h3>Error</h3>
                                <p><?php echo $error; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Permintaan Izin</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Alasan</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                            <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['keterangan'] ?: '-'); ?></td>
                                            <td>
                                                <form method="post" style="display: inline;">
                                                    <input type="hidden" name="id_izin" value="<?php echo $row['id_izin']; ?>">
                                                    <button type="submit" name="action" value="approve" class="btn btn-sm btn-primary">Setujui</button>
                                                    <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger">Tolak</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="logout-button">
                        <a href="karyawan/awal.php" class="btn btn-neutral">Kembali ke Dashboard</a>
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
            $('a').not('[href*="logout"]').on('click', function(e) {
                const href = $(this).attr('href');
                if (href && href !== '#' && href !== '') {
                    e.preventDefault();
                    $('#loading-overlay').addClass('visible');
                    setTimeout(() => window.location.href = href, 600);
                }
            });

            $('.modal-close').on('click', () => {
                $('.modal-overlay').removeClass('show');
            });

            $('.modal-overlay').on('click', (e) => {
                if (e.target === e.currentTarget) {
                    $('.modal-overlay').removeClass('show');
                }
            });
        });
    </script>
</body>
</html>