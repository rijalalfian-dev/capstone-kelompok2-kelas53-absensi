<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['username'])) {
    header("location: index.php");
} else {
    $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - Sistem Informasi Karyawan</title>
    <link rel="icon" href="img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="vendors/linericon/style.css">
    <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Inline overrides for hero banner text and buttons */
        .hero-banner__content h1,
        .hero-banner__content p {
            color: #ffffff !important;
        }

        .light-mode .hero-banner__content h1,
        .light-mode .hero-banner__content p {
            color: #ffffff !important;
        }

        /* Custom styles for admin dashboard */
        .admin-container {
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .admin-header h1 {
            font-size: 2.5rem;
            color: #374151;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #3B82F6;
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
        }

        .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        .btn-danger {
            background-color: #DC2626;
            border-color: #DC2626;
        }

        .btn-danger:hover {
            background-color: #B91C1C;
            border-color: #B91C1C;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #F3F4F6;
            color: #374151;
        }

        .table td img {
            max-width: 50px;
            border-radius: 5px;
        }

        .search-form {
            display: flex;
            max-width: 400px;
            margin: 0 auto 20px;
        }

        .search-form input {
            border-radius: 5px 0 0 5px;
        }

        .search-form button {
            border-radius: 0 5px 5px 0;
            background-color: #3B82F6;
            border-color: #3B82F6;
        }

        .pagination .page-link {
            color: #3B82F6;
        }

        .pagination .page-item.active .page-link {
            background-color: #3B82F6;
            border-color: #3B82F6;
        }
    </style>
</head>

<body>
    <div id="vanta-bg"></div>

    <header class="header_area">
        <div class="container box_1620">
            <h1>Data User</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
        </div>
    </header>

    <main class="side-main">
        <section class="section-margin">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 admin-container">
                        <div class="admin-header">
                            <h1>Kelola Data User</h1>
                        </div>

                        <!-- Sidebar Navigation -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="m-0">Navigasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li><a href="admin2.php" class="d-block py-2"><i class="fas fa-tachometer-alt mr-2"></i> Beranda</a></li>
                                            <li><a href="datakaryawan.php" class="d-block py-2"><i class="fas fa-users mr-2"></i> Data Karyawan</a></li>
                                            <li><a href="datauser.php" class="d-block py-2 text-primary"><i class="fas fa-user-cog mr-2"></i> Data User</a></li>
                                            <li><a href="datajabatan.php" class="d-block py-2"><i class="fas fa-briefcase mr-2"></i> Data Jabatan</a></li>
                                            <li><a href="data_absen.php" class="d-block py-2"><i class="fas fa-calendar-check mr-2"></i> Data Absen</a></li>
                                            <li><a href="data_keterangan.php" class="d-block py-2"><i class="fas fa-file-alt mr-2"></i> Data Keterangan</a></li>
                                            <li><a href="logout.php" class="d-block py-2 text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <!-- Form for Adding User -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="m-0">Tambah User</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="admin_save.php" method="post">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" id="username" required name="username" autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="password">Password</label>
                                                    <input type="text" class="form-control" id="password" required name="password" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                                <button type="reset" class="btn btn-danger">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- User Data Table -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="m-0">Daftar User</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $query1 = "SELECT * FROM tb_daftar ORDER BY id";
                                        $pola = 'asc';
                                        $polabaru = 'asc';

                                        if (isset($_GET['orderby']) && isset($_GET['pola'])) {
                                            $orderby = $_GET['orderby'];
                                            $pola = $_GET['pola'];
                                            $query1 = "SELECT * FROM tb_daftar ORDER BY $orderby $pola";
                                            if ($pola == 'asc') {
                                                $polabaru = 'desc';
                                            } else {
                                                $polabaru = 'asc';
                                            }
                                        }

                                        // Pagination
                                        $batas = 5;
                                        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                                        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                                        $Previous = $halaman - 1;
                                        $next = $halaman + 1;

                                        $data = mysqli_query($koneksi, $query1);
                                        $jumlah_data = mysqli_num_rows($data);
                                        $total_halaman = ceil($jumlah_data / $batas);

                                        $data_user = mysqli_query($koneksi, "$query1 LIMIT $halaman_awal, $batas");
                                        $no = $halaman_awal + 1;
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th><a href="?orderby=id&pola=<?php echo $polabaru; ?>">ID</a></th>
                                                        <th><a href="?orderby=username&pola=<?php echo $polabaru; ?>">Username</a></th>
                                                        <th>Password</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($d = mysqli_fetch_array($data_user)) { ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $d['id']; ?></td>
                                                            <td><?php echo $d['username']; ?></td>
                                                            <td><?php echo $d['password']; ?></td>
                                                            <td>
                                                                <a href="admin/admin_hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <ul class="pagination justify-content-center mt-3">
                                            <li class="page-item <?php if ($halaman <= 1) echo 'disabled'; ?>">
                                                <a class="page-link" href="?halaman=<?php echo $Previous; ?>">Previous</a>
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
        let vantaEffect;
        const vantaElement = document.getElementById('vanta-bg');
        const checkbox = document.getElementById('theme-checkbox');
        const body = document.body;

        function initVanta(isLight) {
            if (vantaEffect) vantaEffect.destroy();
            vantaEffect = VANTA.GLOBE({
                el: "#vanta-bg",
                mouseControls: true,
                touchControls: true,
                gyroControls: true,
                minHeight: 200.00,
                minWidth: 200.00,
                scale: 0.70,
                scaleMobile: 1.00,
                color: isLight ? 0x1b1b82 : 0xffffff,
                backgroundColor: isLight ? 0x756f7f : 0x111111,
                size: 1.2
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (!vantaElement) {
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
        });

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                body.classList.add('light-mode');
                localStorage.setItem('theme', 'light');
                initVanta(true);
            } else {
                body.classList.remove('light-mode');
                localStorage.setItem('theme', 'dark');
                initVanta(false);
            }
        });
    </script>
</body>
</html>