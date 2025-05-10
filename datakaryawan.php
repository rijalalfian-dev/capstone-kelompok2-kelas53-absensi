<?php
session_start();
include __DIR__ . '/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Sistem Informasi Karyawan</title>
    <link rel="icon" href="img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="datakaryawan-page">
    <div id="vanta-bg"></div>
    <div id="loading-overlay">
        <img src="img/Fevicon.png" alt="Loading" class="loading-logo">
    </div>

    <header class="header_area">
        <div class="container">
            <h1>Data Karyawan</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="admin-container">
                    <div class="admin-header">
                        <h1>Kelola Data Karyawan</h1>
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
                                        <li><a href="datakaryawan.php" class="d-block py-2 text-primary"><i class="fas fa-users mr-2"></i> Data Karyawan</a></li>
                                        <li><a href="datauser.php" class="d-block py-2"><i class="fas fa-user-cog mr-2"></i> Data User</a></li>
                                        <li><a href="datajabatan.php" class="d-block py-2"><i class="fas fa-briefcase mr-2"></i> Data Jabatan</a></li>
                                        <li><a href="data_absen.php" class="d-block py-2"><i class="fas fa-calendar-check mr-2"></i> Data Absen</a></li>
                                        <li><a href="data_keterangan.php" class="d-block py-2"><i class="fas fa-file-alt mr-2"></i> Data Keterangan</a></li>
                                        <li><a href="logout.php" class="d-block py-2 text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Tambah Karyawan</h5>
                                </div>
                                <div class="card-body">
                                    <form action="dt_karyawan_sv.php" enctype="multipart/form-data" method="post">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="id_karyawan">NIP</label>
                                                <input type="text" class="form-control" id="id_karyawan" maxlength="9" required name="id_karyawan" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" required name="username" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" required name="password" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" required name="nama" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tmp_tgl_lahir">Tempat & Tgl Lahir</label>
                                                <input type="text" class="form-control" id="tmp_tgl_lahir" required name="tmp_tgl_lahir" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="jenkel">Jenis Kelamin</label>
                                                <select class="form-control" id="jenkel" required name="jenkel">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="agama">Agama</label>
                                                <select class="form-control" id="agama" required name="agama">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Katholik">Katholik</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="KongHuCu">KongHuCu</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="alamat">Alamat</label>
                                                <textarea class="form-control" id="alamat" required name="alamat" autocomplete="off"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="no_tel">No Telepon</label>
                                                <input type="text" class="form-control" id="no_tel" maxlength="18" required name="no_tel" autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="jabatan">Jabatan</label>
                                                <select class="form-control" id="jabatan" required name="jabatan">
                                                    <?php
                                                    $sql = "SELECT * FROM tb_jabatan";
                                                    $hasil = mysqli_query($koneksi, $sql);
                                                    while ($data = mysqli_fetch_array($hasil)) {
                                                        echo "<option value='" . htmlspecialchars($data['jabatan']) . "'>" . htmlspecialchars($data['jabatan']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="foto">Foto</label>
                                                <input type="file" class="form-control" id="foto" required name="foto">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-danger">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form class="search-form" action="prospenkar.php" method="POST">
                                <input class="form-control" type="text" name="cari" placeholder="Cari NIP/Nama" autocomplete="off">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Daftar Karyawan</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT * FROM tb_karyawan ORDER BY id_karyawan";
                                    $pola = 'asc';
                                    $pola_baru = 'asc';

                                    if (isset($_GET['orderby']) && isset($_GET['pola'])) {
                                        $orderby = $_GET['orderby'];
                                        $pola = $_GET['pola'];
                                        $query = "SELECT * FROM tb_karyawan ORDER BY $orderby $pola";
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

                                    $data_karyawan = mysqli_query($koneksi, "$query LIMIT $halaman_awal, $batas");
                                    $no = $halaman_awal + 1;
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><a href="?orderby=id_karyawan&pola=<?php echo $pola_baru; ?>">NIP</a></th>
                                                    <th><a href="?orderby=nama&pola=<?php echo $pola_baru; ?>">Nama</a></th>
                                                    <th>Tempat & Tgl Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Agama</th>
                                                    <th>Alamat</th>
                                                    <th>No Telepon</th>
                                                    <th>Jabatan</th>
                                                    <th>Foto</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($d = mysqli_fetch_array($data_karyawan)) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($d['id_karyawan']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['tmp_tgl_lahir']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['jenkel']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['agama']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['alamat']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['no_tel']); ?></td>
                                                        <td><?php echo htmlspecialchars($d['jabatan']); ?></td>
                                                        <td><img src="images/<?php echo htmlspecialchars($d['foto']); ?>" alt="Foto" style="max-width: 50px;"></td>
                                                        <td>
                                                            <a href="edit_karyawan.php?id=<?php echo htmlspecialchars($d['id_karyawan']); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                            <a href="delete_karyawan.php?id=<?php echo htmlspecialchars($d['id_karyawan']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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