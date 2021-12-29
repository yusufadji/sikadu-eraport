<?php

require_once '../connection.php';
session_start();

if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $userid = $_COOKIE['id'];
    $_SESSION['login_as'] = $login_as;
} else {
    $userid = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}

if (!isset($_SESSION['login_as'])) {
    header('location: ../index.php');
} else {
    if ($_SESSION['login_as'] != "guru") {
        header('location: ../index.php');
    }
}

if (isset($_GET['nis'])) {
    $siswaid = $_GET['nis'];
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
                <li class="hovered">
                    <a href="#">
                        <span class="icon"><i class='bx bx-grid-alt'></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-siswa">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <span class="title">Daftar Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-kelas">
                        <span class="icon"><i class='bx bx-door-open'></i></span>
                        <span class="title">Daftar Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-mapel">
                        <span class="icon"><i class='bx bx-book-alt'></i></span>
                        <span class="title">Daftar Mapel</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-nilai">
                        <span class="icon"><i class='bx bx-book-add'></i></span>
                        <span class="title">Daftar Nilai</span>
                    </a>
                </li>
                <li>
                    <a href="pesan">
                        <span class="icon"><i class='bx bx-chat'></i></span>
                        <span class="title">Pesan</span>
                    </a>
                </li>
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
                Ubah Nilai
            </h2>
            <div class="konten_isi">
                <?php
                $result_siswa = $conn->query("SELECT * FROM siswa WHERE nis = $siswaid LIMIT 1");
                if ($result_siswa && $result_siswa->num_rows > 0) {
                    while ($row = $result_siswa->fetch_assoc()) {
                ?>
                        <form class="konten_ubah_nilai" id="form_ubah_nilai" action="proses_ubah_nilai.php" method="post">
                            <div class="mb-3">
                                <label for="namaSiswa" class="form-label">Nama siswa</label>
                                <input type="text" class="form-control" id="namaSiswa" disabled placeholder="<?php echo $row['nama_siswa']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nomorIndukSiswa" class="form-label">Nomor induk siswa</label>
                                <input type="text" class="form-control" id="nomorIndukSiswa" disabled placeholder="<?php echo $row['nis']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="kelasSiswa" class="form-label">Kelas</label>
                                <?php
                                $nama_kelas = $conn->query("SELECT nama_kelas FROM siswa,kelas WHERE siswa.id_kelas=kelas.id_kelas AND nis=$siswaid");
                                if ($nama_kelas && $nama_kelas->num_rows > 0) {
                                    while ($row = $nama_kelas->fetch_assoc()) {
                                ?>
                                        <input type="text" class="form-control" id="kelasSiswa" disabled placeholder="<?php echo $row['nama_kelas']; ?>">
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="mb-3">
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuMapel" data-bs-toggle="dropdown" aria-expanded="false">
                                        Mata Pelajaran
                                    </a>
                                    <ul class="dropdown-menu" id="dropdown-mapel" aria-labelledby="dropdownMenuMapel">
                                        <?php
                                        $result_mapel = $conn->query("SELECT * FROM mata_pelajaran");
                                        if ($result_mapel && $result_mapel->num_rows > 0) {
                                            while ($row = $result_mapel->fetch_assoc()) {
                                        ?>
                                                <li><a class="dropdown-item" data-mapel="<?php echo $row['id_mapel'] ?>" href="#"><?php echo $row['nama_mapel'] ?></a></li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            $nilai_siswa = $conn->query("SELECT * FROM siswa,nilai WHERE nilai.nis = $siswaid");

                            $row = $nilai_siswa->fetch_assoc();
                            ?>
                            <div class="mb-3">
                                <label for="nilaiSiswaCP1" class="form-label">CP1</label>
                                <input type="number" name="nilaicp1" min="0" max="100" class="form-control" id="nilaiSiswaCP1" value="<?php echo $row['cp1']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nilaiSiswaCP2" class="form-label">CP2</label>
                                <input type="number" name="nilaicp2" min="0" max="100" class="form-control" id="nilaiSiswaCP2" value="<?php echo $row['cp2']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nilaiSiswaCP3" class="form-label">CP3</label>
                                <input type="number" name="nilaicp3" min="0" max="100" class="form-control" id="nilaiSiswaCP3" value="<?php echo $row['cp3']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nilaiSiswaCP4" class="form-label">CP4</label>
                                <input type="number" name="nilaicp4" min="0" max="100" class="form-control" id="nilaiSiswaCP4" value="<?php echo $row['cp4']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nilaiSiswaUTS" class="form-label">UTS</label>
                                <input type="number" name="nilaiuts" min="0" max="100" class="form-control" id="nilaiSiswaUTS" value="<?php echo $row['uts']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nilaiSiswaUAS" class="form-label">UAS</label>
                                <input type="number" name="nilaiuas" min="0" max="100" class="form-control" id="nilaiSiswaUAS" value="<?php echo $row['uas']; ?>">
                            </div>
                        </form>
                        <div class="konten_ubah_nilai_opsi">
                            <a href="daftar-nilai"><button class="btn btn-danger">Batalkan</button></a>
                            <a href="daftar-nilai"><button type="submit" class="btn btn-primary">Simpan</button></a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>