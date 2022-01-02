<?php
session_start();
require_once 'connection.php';
require_once 'utils.php';
require_once 'model/guru.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

$query = "SELECT * FROM $login_as WHERE " . (($login_as == "admin" ? "id_admin" : $login_as == "guru") ? "nip" : "nis") . " = $userid";
$get_user = $conn->query($query);


// $conn->next_result();
if ($get_user->num_rows === 1) {
    $row = $get_user->fetch_assoc();

    if (isset($_COOKIE['id'])) {
        if ($kodenuklir !== hash('sha256', $row['email'])) {
            header("location: logout");
        }
    }
    $logged_email = $row["email"];
} else {
    header("location: logout");
}

if ($login_as == "guru") {
    $guru = new Guru($userid);
    $wali_kelas = $guru->cek_wali_kelas();

    if ($wali_kelas) {
        $is_walikelas = true;
    } else {
        $is_walikelas = false;
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
                    <li>
                        <a href="admin/data-nilai">
                            <span class="icon"><i class='bx bx-book-add'></i></span>
                            <span class="title">Data Nilai</span>
                        </a>
                    </li>
                <?php
                } //endif $login_as == 'admin'

                if ($login_as == "siswa" || ($login_as == "guru" && $is_walikelas)) {

                ?>

                    <li>
                        <a href="<?php echo $logis_as == "guru" ? "guru" : "std"; ?>/pesan">
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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA" alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                <?php
                if ($login_as == "guru") {
                    $nama_guru = $guru->get_nama_guru();
                    echo "Selamat datang, $nama_guru";
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
                                        <h2 class="text-left"><i class="fa fa-cart-plus f-left"></i><span>2020/2021</span></h2>
                                        <p class="m-b-0"><?php echo hari_ini(); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-green guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Semester</h6>
                                        <h2 class="text-end"><i class="fa fa-rocket f-left"></i><span>2</span></h2>
                                        <p class="m-b-0">Semester Genap</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-yellow guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Anda Wali Kelas</h6>
                                        <h2 class="text-end"><i class="fa fa-refresh f-left"></i><span><?php echo $wali_kelas->num_rows ?></span></h2>
                                        <p class="m-b-0">Kelas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="card bg-c-pink guru-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Anda Mengajar</h6>
                                        <h2 class="text-end"><i class="fa fa-refresh f-left"></i><span><?php echo $wali_kelas->num_rows ?></span></h2>
                                        <p class="m-b-0">Mapel</p>
                                    </div>
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
                                <td>{{ tgl1 }}</td>
                                <td>{{ agd1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl2 }}</td>
                                <td>{{ agd2 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl3 }}</td>
                                <td>{{ agd3 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl4 }}</td>
                                <td>{{ agd4 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl5 }}</td>
                                <td>{{ agd5 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl6 }}</td>
                                <td>{{ agd6 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl7 }}</td>
                                <td>{{ agd7 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl8 }}</td>
                                <td>{{ agd8 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl9 }}</td>
                                <td>{{ agd9 }}</td>
                            </tr>
                            <tr>
                                <td>{{ tgl10 }}</td>
                                <td>{{ agd10 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
        <script type="text/javascript">
            function ready(f) {
                /in/.test(document.readyState) ? setTimeout('ready(' + f + ')', 9) : f();
            }
            const u7936882821 = {
                tgl1: '26 Agustus - 03 September 2021',
                tgl2: '20 - 25 September 2021',
                tgl3: '27 September - 13 November 2021',
                tgl4: '23 Oktober 2021',
                tgl5: '23 Oktober 2021',
                tgl6: '15 - 24 November 2021 (9 hari)',
                tgl7: '18 Desember 2021',
                tgl8: '25 November 2021 - 12 Januari 2022',
                tgl9: '13 - 22 Januari 2022 (9 hari)',
                tgl10: '27 Januari 2022',
                agd1: 'Registrasi & Pengisian KRS Mahasiswa Lama Ganjil 2021/2022',
                agd2: 'Pengarahan Akademik dan Pengisian KRS Mahasiswa Baru',
                agd3: 'Perkuliahan Tahap 1 (7 Minggu)',
                agd4: 'Dies Natalies Universitas',
                agd5: 'Upacara Wisuda',
                agd6: 'Ujian Tengah Semester 1 (UTS)',
                agd7: 'Upacara Wisuda',
                agd8: 'Perkuliahan Tahap 2 (7 Minggu)',
                agd9: 'Ujian Akhir Semester 1 (UAS)',
                agd10: 'Yudisium Semester Ganjil'
            }
            ready(function() {
                var appinfo = new Vue({
                    el: '#kalender',
                    data: u7936882821
                })
            });
        </script>
        <script src="assets/js/main.js"></script>
        <!-- <script>
            alert("Anda login sebagai <?php echo $login_as ?>")
        </script> -->
</body>

</html>