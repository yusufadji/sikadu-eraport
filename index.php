<?php
session_start();
require_once 'connection.php';
require_once 'config_sekolah.php';
require_once 'utils.php';
require_once 'model/guru.php';
require_once 'model/siswa.php';
require_once 'model/admin.php';
require_once 'model/kelas.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: login/siswa');
}
// ambil userid dari session atau cookie
if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $userid = $_COOKIE['id'];
    $kodenuklir = $_COOKIE['kodenuklir'];
} else {
    $userid = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}

if ($login_as == "admin") {
    $admin = new Admin();
    $get_user = $admin->get_detail_admin_by_id($userid);
} elseif ($login_as == "guru") {
    $guru = new Guru();
    $kelas = new Kelas();
    $get_user = $guru->get_detail_guru($userid);
    $wali_kelas = $kelas->cek_wali_kelas($userid);

    if ($wali_kelas) {
        $is_walikelas = true;
    } else {
        $is_walikelas = false;
    }
} elseif ($login_as == "siswa") {
    $siswa = new Siswa();
    $get_user = $siswa->get_detail_siswa($userid);
}

if (!$get_user) {
    header('location: logout');
}

if (isset($_COOKIE['id'])) {
    if ($kodenuklir !== hash('sha256', $get_user['email'])) {
        header("location: logout");
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"></span>
                        <h1 class="title">E-Raport</h1>
                    </a>
                </li>
                <li class="hovered">
                    <a href="#">
                        <span class="icon"><i class='bx bx-grid-alt'></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php
                // tampilkan menu guru jika login sebagai guru
                if ($login_as == "siswa") {
                ?>
                    <li>
                        <a href="std/profil">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Profil</span>
                        </a>
                    </li>
                <?php
                } // endif $login_as == 'siswa'

                if ($login_as == "guru") {

                ?>
                    <li>
                        <a href="guru/daftar-siswa">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Daftar Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="guru/daftar-kelas">
                            <span class="icon"><i class='bx bx-door-open'></i></span>
                            <span class="title">Daftar Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a href="guru/daftar-mapel">
                            <span class="icon"><i class='bx bx-book-alt'></i></span>
                            <span class="title">Daftar Mapel</span>
                        </a>
                    </li>
                    <li>
                        <a href="guru/daftar-nilai">
                            <span class="icon"><i class='bx bx-book-add'></i></span>
                            <span class="title">Daftar Nilai</span>
                        </a>
                    </li>
                <?php
                } // endif $login_as == 'guru'

                if ($login_as == "admin") {
                ?>
                    <li>
                        <a href="admin/data-guru">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Data Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin/data-siswa">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin/data-kelas">
                            <span class="icon"><i class='bx bx-door-open'></i></span>
                            <span class="title">Data Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin/data-mapel">
                            <span class="icon"><i class='bx bx-book-alt'></i></span>
                            <span class="title">Data Mapel</span>
                        </a>
                    </li>
                <?php
                } //endif $login_as == 'admin'

                if ($login_as == "siswa" || ($login_as == "guru" && $is_walikelas)) {

                ?>

                    <li>
                        <a href="<?php echo $login_as == "guru" ? "guru" : "std"; ?>/pesan">
                            <span class="icon"><i class='bx bx-chat'></i></span>
                            <span class="title">Pesan</span>
                        </a>
                    </li>
                <?php
                } //endif $login_as == "siswa" || ($login_as == "guru" && $is_walikelas

                // tampilkan prestasi jika login sebagai siswa
                if ($login_as == "siswa") {

                ?>
                    <li>
                        <a href="std/prestasi">
                            <span class="icon"><i class='bx bxs-graduation'></i></span>
                            <span class="title">Prestasi</span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a href="logout">
                        <span class="icon"><i class='bx bx-exit'></i></span>
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <!-- main -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <i class='bx bx-menu'></i>
            </div>
            <!-- user -->
            <div class="user">
                <?php 
                if ($login_as == "siswa") {
                    $pp = "assets/img/pp/std.png";
                } elseif ($login_as == "guru") {
                    $pp = "assets/img/pp/guru.png";
                } elseif ($login_as == "admin") {
                    $pp = "assets/img/pp/admin.png";
                }
                ?>
                <img src="<?php echo $pp; ?>" alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                <?php
                if ($login_as == "guru") {
                    $nama_guru = $guru->get_nama_guru($userid);
                    echo "Selamat datang, $nama_guru";
                }
                if ($login_as == "siswa") {
                    $nama_siswa = $siswa->get_nama_siswa($userid);
                    echo "Selamat datang, $nama_siswa";
                }
                if ($login_as == "admin") {
                    $nama_admin = $get_user["nama_admin"];
                    echo "Selamat datang, $nama_admin";
                }
                ?>
            </h2>
            <div class="konten_isi">
                <?php

                if ($login_as == "guru") {

                ?>
                    <!-- Dashboard Guru -->
                    <div class="dashboard-container">
                        <div class="row">
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-blue guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Tahun Ajaran</h6>
                                        <h3 class="text-left"><i class="fa fa-cart-plus f-left"></i><span>2020/2021</span></h3>
                                        <p class="m-b-0"><?php echo hari_ini(); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-green guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Semester</h6>
                                        <h3 class="text-end"><i class="fa fa-rocket f-left"></i><span>2</span></h3>
                                        <p class="m-b-0">Semester Genap</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-yellow guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Anda Wali Kelas</h6>
                                        <h3 class="text-end"><i class="fa fa-refresh f-left"></i><span><?php echo $is_walikelas ? $wali_kelas->num_rows : 0; ?></span></h3>
                                        <p class="m-b-0">Kelas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-pink guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Anda Mengajar</h6>
                                        <h3 class="text-end"><i class="fa fa-refresh f-left"></i><span><?php echo $is_walikelas ? $wali_kelas->num_rows : 0; ?></span></h3>
                                        <p class="m-b-0">Mapel</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php
                }
                    ?>
                    <div class="konten_table table-responsive">
                        <table class="table table-bordered caption-top" id="kalender">
                            <caption>Kalender Akademik 2021</caption>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo JADWAL['tgl1'] ?></td>
                                    <td><?php echo JADWAL['agd1'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl2'] ?></td>
                                    <td><?php echo JADWAL['agd2'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl3'] ?></td>
                                    <td><?php echo JADWAL['agd3'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl4'] ?></td>
                                    <td><?php echo JADWAL['agd4'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl5'] ?></td>
                                    <td><?php echo JADWAL['agd5'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl6'] ?></td>
                                    <td><?php echo JADWAL['agd6'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl7'] ?></td>
                                    <td><?php echo JADWAL['agd7'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl8'] ?></td>
                                    <td><?php echo JADWAL['agd8'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl9'] ?></td>
                                    <td><?php echo JADWAL['agd9'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo JADWAL['tgl10'] ?></td>
                                    <td><?php echo JADWAL['agd10'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript">
                function ready(f) {
                    /in/.test(document.readyState) ? setTimeout('ready(' + f + ')', 9) : f();
                }
                
            </script>
            <script src="assets/js/main.js"></script>

</body>

</html>