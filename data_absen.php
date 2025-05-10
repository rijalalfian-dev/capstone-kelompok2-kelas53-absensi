<?php
session_start();
require_once "koneksi.php";

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
    <title>Data Absen - Sistem Informasi Karyawan</title>
    <link rel="icon" href="img/Fevicon.png" type="image/png">
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <style>
        body {
            background: #111;
            color: #111;
            font-family: "Roboto", sans-serif;
            font-size: 0.95rem;
            font-weight: 400;
            line-height: 1.667;
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
        .form-control, .select2-container--default .select2-selection--single {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
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
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
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
            border-radius: 24px;
            transition: 0.4s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
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
            transform: translateX(26px);
        }
        .light-mode {
            background: #f0f0f0;
        }
        .geo-link {
            color: #3B82F6;
            text-decoration: none;
        }
        .geo-link:hover {
            text-decoration: underline;
        }
        .status-pending {
            color: #FFA500;
            font-weight: bold;
        }
        .status-approved {
            color: #28A745;
            font-weight: bold;
        }
        .status-rejected {
            color: #DC2626;
            font-weight: bold;
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
            <h1>Data Absen</h1>
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
        </div>
    </header>

    <main class="site-main">
        <section class="section-margin">
            <div class="container">
                <div class="admin-container">
                    <div class="admin-header">
                        <h1>Kelola Data Absen</h1>
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
                                        <li><a href="data_absen.php" class="d-block py-2 text-primary"><i class="fas fa-calendar-check mr-2"></i> Data Absen</a></li>
                                        <li><a href="data_keterangan.php" class="d-block py-2"><i class="fas fa-file-alt mr-2"></i> Data Keterangan</a></li>
                                        <li><a href="logout.php" class="d-block py-2 text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Tampilkan Absensi</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label for="id_karyawan">Pilih Karyawan</label>
                                                <select class="form-control select2" id="id_karyawan" name="id_karyawan">
                                                    <option value="">-- Semua Karyawan --</option>
                                                    <?php
                                                    $sql = "SELECT id_karyawan, nama FROM tb_karyawan ORDER BY nama";
                                                    $hasil = mysqli_query($koneksi, $sql);
                                                    while ($data = mysqli_fetch_array($hasil)) {
                                                        $selected = (isset($_GET['id_karyawan']) && $_GET['id_karyawan'] == $data['id_karyawan']) ? 'selected' : '';
                                                        echo "<option value='{$data['id_karyawan']}' data-nip='{$data['id_karyawan']}' $selected>{$data['nama']} ({$data['id_karyawan']})</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3 align-self-end">
                                                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Daftar Absen</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Base query
                                    $query = "
                                        SELECT 
                                            k.nama,
                                            DATE(a1.waktu) AS tanggal,
                                            MAX(CASE WHEN a1.jenis_absen = 'masuk' THEN a1.waktu END) AS jam_masuk,
                                            MAX(CASE WHEN a1.jenis_absen = 'pulang' THEN a1.waktu END) AS jam_pulang,
                                            MAX(CASE WHEN a1.jenis_absen = 'masuk' THEN CONCAT(a1.latitude_masuk, ',', a1.longitude_masuk) END) AS geo_masuk,
                                            MAX(CASE WHEN a1.jenis_absen = 'pulang' THEN CONCAT(a1.latitude_pulang, ',', a1.longitude_pulang) END) AS geo_pulang,
                                            i.jenis_izin,
                                            i.status
                                        FROM tb_karyawan k
                                        LEFT JOIN tb_absen a1 ON k.id_karyawan = a1.id_karyawan
                                        LEFT JOIN tb_izin i ON k.id_karyawan = i.id_karyawan 
                                            AND DATE(a1.waktu) BETWEEN i.tanggal_mulai AND i.tanggal_selesai
                                        WHERE a1.waktu IS NOT NULL
                                    ";

                                    // Parameters for prepared statement
                                    $params = [];
                                    $types = '';

                                    // Search filter
                                    $search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
                                    if (!empty($search)) {
                                        $query .= " AND k.nama LIKE ?";
                                        $params[] = "%$search%";
                                        $types .= 's';
                                    }

                                    // Karyawan filter
                                    $id_karyawan = isset($_GET['id_karyawan']) && $_GET['id_karyawan'] !== '' ? (int)$_GET['id_karyawan'] : null;
                                    if ($id_karyawan) {
                                        $query .= " AND k.id_karyawan = ?";
                                        $params[] = $id_karyawan;
                                        $types .= 'i';
                                    }

                                    // Sorting
                                    $pola = 'desc';
                                    $pola_baru = 'desc';
                                    $orderby = 'tanggal';
                                    if (isset($_GET['orderby']) && isset($_GET['pola'])) {
                                        $orderby = mysqli_real_escape_string($koneksi, $_GET['orderby']);
                                        $pola = mysqli_real_escape_string($koneksi, $_GET['pola']);
                                        $pola_baru = ($pola == 'asc') ? 'desc' : 'asc';
                                    }
                                    $query .= " GROUP BY k.id_karyawan, DATE(a1.waktu) ORDER BY $orderby $pola";

                                    // Pagination
                                    $batas = 5;
                                    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;

                                    // Count total records
                                    $stmt = $koneksi->prepare($query);
                                    if (!empty($params)) {
                                        $stmt->bind_param($types, ...$params);
                                    }
                                    $stmt->execute();
                                    $data = $stmt->get_result();
                                    $jumlah_data = $data->num_rows;
                                    $total_halaman = ceil($jumlah_data / $batas);
                                    $stmt->close();

                                    // Fetch paginated data
                                    $query .= " LIMIT ?, ?";
                                    $params[] = $halaman_awal;
                                    $params[] = $batas;
                                    $types .= 'ii';

                                    $stmt = $koneksi->prepare($query);
                                    if (!empty($params)) {
                                        $stmt->bind_param($types, ...$params);
                                    }
                                    $stmt->execute();
                                    $data_absen = $stmt->get_result();
                                    $stmt->close();

                                    $no = $halaman_awal + 1;
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th><a href="?orderby=nama&pola=<?php echo $pola_baru; ?><?php echo $search ? '&cari=' . urlencode($search) : ''; ?><?php echo $id_karyawan ? '&id_karyawan=' . $id_karyawan : ''; ?>">Nama</a></th>
                                                    <th><a href="?orderby=tanggal&pola=<?php echo $pola_baru; ?><?php echo $search ? '&cari=' . urlencode($search) : ''; ?><?php echo $id_karyawan ? '&id_karyawan=' . $id_karyawan : ''; ?>">Tanggal</a></th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Lokasi Masuk</th>
                                                    <th>Lokasi Pulang</th>
                                                    <th>Izin</th>
                                                    <th>Status Izin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($d = $data_absen->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $no; ?></td>
                                                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($d['tanggal'])); ?></td>
                                                        <td><?php echo $d['jam_masuk'] ? date('H:i:s', strtotime($d['jam_masuk'])) : '-'; ?></td>
                                                        <td><?php echo $d['jam_pulang'] ? date('H:i:s', strtotime($d['jam_pulang'])) : '-'; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($d['geo_masuk'] && $d['geo_masuk'] !== ',') {
                                                                echo '<a href="https://maps.google.com/?q=' . htmlspecialchars($d['geo_masuk']) . '" target="_blank" class="geo-link">Lihat</a>';
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($d['geo_pulang'] && $d['geo_pulang'] !== ',') {
                                                                echo '<a href="https://maps.google.com/?q=' . htmlspecialchars($d['geo_pulang']) . '" target="_blank" class="geo-link">Lihat</a>';
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $d['jenis_izin'] ? htmlspecialchars($d['jenis_izin']) : '-'; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($d['status']) {
                                                                $status_class = 'status-' . strtolower($d['status']);
                                                                echo '<span class="' . $status_class . '">' . htmlspecialchars($d['status']) . '</span>';
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                        <?php if ($jumlah_data == 0): ?>
                                            <p class="text-center">Tidak ada data absensi yang ditemukan.</p>
                                        <?php endif; ?>
                                    </div>
                                    <ul class="pagination justify-content-center mt-3">
                                        <li class="page-item <?php if ($halaman <= 1) echo 'disabled'; ?>">
                                            <a class="page-link" href="?halaman=<?php echo $previous; ?><?php echo $search ? '&cari=' . urlencode($search) : ''; ?><?php echo $id_karyawan ? '&id_karyawan=' . $id_karyawan : ''; ?>&orderby=<?php echo $orderby; ?>&pola=<?php echo $pola; ?>">Previous</a>
                                        </li>
                                        <?php for ($x = 1; $x <= $total_halaman; $x++) { ?>
                                            <li class="page-item <?php if ($x == $halaman) echo 'active'; ?>">
                                                <a class="page-link" href="?halaman=<?php echo $x; ?><?php echo $search ? '&cari=' . urlencode($search) : ''; ?><?php echo $id_karyawan ? '&id_karyawan=' . $id_karyawan : ''; ?>&orderby=<?php echo $orderby; ?>&pola=<?php echo $pola; ?>"><?php echo $x; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($halaman >= $total_halaman) echo 'disabled'; ?>">
                                            <a class="page-link" href="?halaman=<?php echo $next; ?><?php echo $search ? '&cari=' . urlencode($search) : ''; ?><?php echo $id_karyawan ? '&id_karyawan=' . $id_karyawan : ''; ?>&orderby=<?php echo $orderby; ?>&pola=<?php echo $pola; ?>">Next</a>
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

    <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

            // Initialize Select2
            $('.select2').select2({
                placeholder: '-- Semua Karyawan --',
                allowClear: true,
                templateResult: function(data) {
                    if (!data.id) return data.text;
                    return $('<span>' + data.text + ' (' + $(data.element).data('nip') + ')</span>');
                },
                templateSelection: function(data) {
                    if (!data.id) return data.text;
                    return data.text + ' (' + $(data.element).data('nip') + ')';
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