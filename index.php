<?php
session_start();
require('connection.php');

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

// coba2
$is_walikelas = true;
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
                        <a href="profil">
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
                        <a href="data-guru">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Data Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="data-siswa">
                            <span class="icon"><i class='bx bx-user'></i></span>
                            <span class="title">Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="data-kelas">
                            <span class="icon"><i class='bx bx-door-open'></i></span>
                            <span class="title">Data Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a href="data-mapel">
                            <span class="icon"><i class='bx bx-book-alt'></i></span>
                            <span class="title">Data Mapel</span>
                        </a>
                    </li>
                    <li>
                        <a href="data-nilai">
                            <span class="icon"><i class='bx bx-book-add'></i></span>
                            <span class="title">Data Nilai</span>
                        </a>
                    </li>
                <?php
                } //endif $login_as == 'admin'

                if ($login_as == "siswa" || ($login_as == "guru" && $is_walikelas)) {
                    # code...
                ?>

                    <li>
                        <a href="./pesan">
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
                        <a href="./prestasi">
                            <span class="icon"><i class='bx bxs-graduation'></i></span>
                            <span class="title">Prestasi</span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a href="#">
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
                Pengumuman
            </h2>
            <div class="konten_isi">
                <div class="konten_table table-responsive">
                    <table class="table table-bordered caption-top">
                        <caption>Kalender Akademik 2021</caption>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>26 Agustus - 03 September 2021</td>
                                <td>UTS</td>
                            </tr>
                            <tr>
                                <td>26 Agustus - 03 September 2021</td>
                                <td>UTS</td>
                            </tr>
                            <tr>
                                <td>26 Agustus - 03 September 2021</td>
                                <td>UTS</td>
                            </tr>
                            <tr>
                                <td>26 Agustus - 03 September 2021</td>
                                <td>UTS</td>
                            </tr>
                            <tr>
                                <td>26 Agustus - 03 September 2021</td>
                                <td>UTS</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script>
            alert("Anda login sebagai <?php echo $login_as ?>")
        </script>
</body>

</html>