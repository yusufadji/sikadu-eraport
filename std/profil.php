<?php

session_start();
require_once '../connection.php';

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

$result = $conn->query("SELECT * FROM siswa WHERE nis = '$userid'");

if ($result) {
    if ($result->num_rows === 1) {
        $siswa = $result->fetch_assoc();
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
    <link rel="stylesheet" href="../assets/css/style.css">
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
                <li>
                    <a href="../index">
                        <span class="icon"><i class='bx bx-grid-alt'></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="hovered">
                    <a href="#">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <span class="title">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="pesan">
                        <span class="icon"><i class='bx bx-chat'></i></span>
                        <span class="title">Pesan</span>
                    </a>
                </li>
                <li>
                    <a href="prestasi">
                        <span class="icon"><i class='bx bxs-graduation'></i></span>
                        <span class="title">Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="../logout">
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
                Profil Siswa
            </h2>
            <div class="konten_isi" id="data-pribadi">
                <div class="konten_profil">
                    <div class="konten_profil_foto">
                        <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA" alt="user" title="Foto profil siswa" />
                    </div>
                </div>
                <!-- <div class="konten_pengaturan">
                    <button type="button" class="btn btn-primary">Ubah Profil</button>
                </div> -->
                <div class="konten_table table-responsive">
                    <table class="table table-bordered konten_profil_biodata">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td><?php echo $siswa['nama_siswa'] ?></td>
                            </tr>
                            <tr>
                                <td>Nomor Induk Siswa</td>
                                <td><?php echo $siswa['nis'] ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?php echo $siswa['alamat'] ?></td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td><?php echo $siswa['no_telp'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $siswa['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td><?php echo $siswa['tanggal_lahir'] ?></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td><?php echo $siswa['jenis_kelamin'] ?></td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td><?php echo $siswa['agama'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/main.js"></script>
</body>

</html>