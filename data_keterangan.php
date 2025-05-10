<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keterangan - Sistem Informasi Karyawan</title>
    <link rel="icon" href="img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            transition: filter 0.6s;
        }
        #vanta-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s, visibility 0.6s;
        }
        #loading-overlay.visible {
            opacity: 1;
            visibility: visible;
        }
        .admin-container {
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .admin-header h1 {
            font-size: 2rem;
            color: #374151;
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background: #3B82F6;
            color: #fff;
            padding: 12px;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 15px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background: #3B82F6;
            border-color: #3B82F6;
        }
        .btn-primary:hover {
            background: #2563EB;
            border-color: #2563EB;
        }
        .btn-danger {
            background: #DC2626;
            border-color: #DC2626;
        }
        .btn-danger:hover {
            background: #B91C1C;
            border-color: #B91C1C;
        }
        .table {
            background: #fff;
            border-radius: 8px;
        }
        .table th {
            background: #F3F4F6;
            color: #374151;
        }
        .search-form {
            display: flex;
            max-width: 300px;
            margin: 0 auto 20px;
        }
        .search-form input {
            border-radius: 5px 0 0 5px;
        }
        .search-form button {
            border-radius: 0 5px 5px 0;
            background: #3B82F6;
            border-color: #3B82F6;
        }
        .pagination .page-link {
            color: #3B82F6;
        }
        .pagination .page-item.active .page-link {
            background: #3B82F6;
            border-color: #3B82F6;
        }
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ccc;
            border-radius: 20px;
            transition: 0.4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background: #fff;
            border-radius: 50%;
            transition: 0.4s;
        }
        input:checked + .slider {
            background: #3B82F6;
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        .light-mode {
            background: #f0f0f0;
        }
        .blurring {
            filter: blur(5px);
        }
        .bukti-img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <header class="header_area">
        <div class="container">
            <h1>Data Keterangan</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="admin-container">
                    <div class="admin-header">
                        <h1>Kelola Data Keterangan</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Navigasi</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><a href="admin2.php" class="d-block py-2"><i class="fas fa-tachometer-alt mr-2"></i> Beranda</a></li>
                                        <li><a href="datakaryawan.php" class="d-block py-2"><i class="fas fa-users mr-2"></i> Data Karyawan</a></li>
                                        <li><a href="datauser.php" class="d-block py-2"><i class="fas fa-user-cog mr-2"></i> Data User</a></li>
                                        <li><a href="datajabatan.php" class="d-block py-2"><i class="fas fa-briefcase mr-2"></i> Data Jabatan</a></li>
                                        <li><a href="data_absen.php" class="d-block py-2"><i class="fas fa-calendar-check mr-2"></i> Data Absen</a></li>
                                        <li><a href="data_keterangan.php" class="d-block py-2 text-primary"><i class="fas fa-file-alt mr-2"></i> Data Keterangan</a></li>
                                        <li><a href="logout.php" class="d-block py-2 text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <form class="search-form" action="prospenket.php" method="POST">
                                <input class="form-control" type="text" name="cari" placeholder="Cari ID/Nama Karyawan" autocomplete="off">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </form>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Tambah Keterangan</h5>
                                </div>
                                <div class="card-body">
                                    <form action="keterangan_sv.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="id_karyawan">NIP</label>
                                                <select class="form-control" id="id_karyawan" required name="id_karyawan">
                                                    <option value="">-- Pilih Karyawan --</option>
                                                    <?php
                                                    $sql = "SELECT id_karyawan, nama FROM tb_karyawan";
                                                    $hasil = mysqli_query($koneksi, $sql);
                                                    while ($data = mysqli_fetch_array($hasil)) {
                                                        echo "<option value='{$data['id_karyawan']}'>{$data['id_karyawan']} - {$data['nama']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="keterangan">Keterangan</label>
                                                <select class="form-control" id="keterangan" required name="keterangan">
                                                    <option value="">-- Pilih Keterangan --</option>
                                                    <option value="Izin">Izin</option>
                                                    <option value="Sakit">Sakit</option>
                                                    <option value="Cuti">Cuti</option>
                                                    <option value="Alfa">Alfa</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="alasan">Alasan</label>
                                                <input type="text" class="form-control" id="alasan" required name="alasan" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="waktu">Waktu</label>
                                                <input type="datetime-local" class="form-control" id="waktu" required name="waktu" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bukti">Bukti (Gambar)</label>
                                                <input type="file" class="form-control" id="bukti" name="bukti" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-danger">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Daftar Keterangan</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT * FROM tb_keterangan ORDER BY waktu DESC";
                                    $pola = 'desc';
                                    $pola_baru = 'desc';

                                    if (isset($_GET['orderby']) && isset($_GET['pola'])) {
                                        $orderby = $_GET['orderby'];
                                        $pola = $_GET['pola'];
                                        $query = "SELECT * FROM tb_keterangan ORDER BY $orderby $pola";
                                        $pola_baru = ($pola == 'asc') ? 'desc' : 'asc';
                                    }

                                    $batas = 5;
                                    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;

                                    $data = mysqli_query($koneksi, $query);
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);

                                    $data_keterangan = mysqli_query($koneksi, "$query LIMIT $halaman_awal, $batas");
                                    $no = $halaman_awal + 1;
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th><a href="?orderby=id_karyawan&pola=<?php echo $pola_baru; ?>">NIP</a></th>
                                                    <th><a href="?orderby=nama&pola=<?php echo $pola_baru; ?>">Nama</a></th>
                                                    <th><a href="?orderby=keterangan&pola=<?php echo $pola_baru; ?>">Keterangan</a></th>
                                                    <th><a href="?orderby=alasan&pola=<?php echo $pola_baru; ?>">Alasan</a></th>
                                                    <th><a href="?orderby=waktu&pola=<?php echo $pola_baru; ?>">Waktu</a></th>
                                                    <th>Bukti</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($d = mysqli_fetch_array($data_keterangan)) { ?>
                                                    <tr>
                                                        <td><?php echo $no; ?></td>
                                                        <td><?php echo $d['id_karyawan']; ?></td>
                                                        <td><?php echo $d['nama']; ?></td>
                                                        <td><?php echo $d['keterangan']; ?></td>
                                                        <td><?php echo $d['alasan']; ?></td>
                                                        <td><?php echo $d['waktu']; ?></td>
                                                        <td>
                                                            <?php if ($d['bukti']) { ?>
                                                                <a href="uploads/<?php echo $d['bukti']; ?>" target="_blank">
                                                                    <img src="Uploads/<?php echo $d['bukti']; ?>" alt="Bukti" class="bukti-img">
                                                                </a>
                                                            <?php } else { ?>
                                                                Tidak ada
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="edit_keterangan.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                            <a href="hapus_keterangan.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="pagination justify-content-center mt-3">
                                        <li class="page-item <?php if ($halaman <= 1) echo 'disabled'; ?>">
                                            <a class="page-link" href="?halaman=<?php echo $previous; ?>">Previous</a>
                                        </li>
                                        <?php for ($x = 1; $x <= $total_halaman; $x++) { ?>
                                            <li class="page-item <?php if ($x == $halaman) echo 'active'; ?>">
                                                <a class="page-link" href="?halaman=<?php echo $x; ?>"><?php echo $x; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($halaman >= $total_halaman) echo 'disabled'; ?>">
                                            <a class="page-link" href="?halaman=<?php echo $next; ?>">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-area section-gap">
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

    <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
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
            if (!vantaEl) return;
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
                    body.classList.add('blurring');
                    $('#loading-overlay').addClass('visible');
                    setTimeout(() => window.location.href = href, 600);
                }
            });
        });
    </script>
</body>
</html>