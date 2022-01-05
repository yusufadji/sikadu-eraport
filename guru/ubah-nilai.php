<?php

require_once dirname(__FILE__) . '/../connection.php';
require_once dirname(__FILE__) . '/../model/nilai.php';
require_once dirname(__FILE__) . '/../model/guru.php';
require_once dirname(__FILE__) . '/../model/siswa.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: logout');
    exit();
}

$nip = $_SESSION['id'];
$login_as = $_SESSION['login_as'];

if (!isset($_SESSION['login_as']) || $_SESSION['login_as'] != "guru") {
    header('location: ../index');
    exit();
}

if (isset($_GET['nis'])) {
    $siswaid = $_GET['nis'];
} else {
    header('location: daftar-nilai');
}

if (isset($_GET['mapel'])) {
    $mapelid = $_GET['mapel'];
} else {
    $mapelid = 0;
}

$nilai = new Nilai($siswaid);
$guru = new Guru();
$siswa = new Siswa();
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
                                <?php 
                if ($login_as == "siswa") {
                    $pp = "../assets/img/pp/std.png";
                } elseif ($login_as == "guru") {
                    $pp = "../assets/img/pp/guru.png";
                } elseif ($login_as == "admin") {
                    $pp = "../assets/img/pp/admin.png";
                }
                ?>
                <img src="<?php echo $pp; ?>" alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                <a href="./daftar-nilai" class="back-btn"><i class='bx bx-arrow-back'></i></a>
                Ubah Nilai
            </h2>
            <div class="konten_isi">
                <?php
                $result_siswa = $siswa->get_detail_siswa($siswaid);
                if ($result_siswa) {

                ?>
                    <form class="konten_ubah_nilai was-validated" id="form_ubah_nilai" name="form_nilai" action="../controller/action_nilai" method="post">
                        <div class="mb-3">
                            <label for="namaSiswa" class="form-label">Nama siswa</label>
                            <input type="text" class="form-control" id="namaSiswa" disabled value="<?php echo $result_siswa['nama_siswa']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nomorIndukSiswa" class="form-label">Nomor induk siswa</label>
                            <input type="text" name="nis-disabled" class="form-control" id="nomorIndukSiswa" disabled value="<?php echo $result_siswa['nis']; ?>" placeholder="<?php echo $result_siswa['nis']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="kelasSiswa" class="form-label">Kelas</label>
                            <?php
                            $nama_kelas = $siswa->get_kelas_siswa($siswaid);
                            if ($nama_kelas) {

                            ?>
                                <input type="text" class="form-control" id="kelasSiswa" disabled value="<?php echo $nama_kelas; ?>">
                            <?php

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
                                    $result_mapel = $guru->get_mapel_by_guru($nip);
                                    if ($result_mapel && $result_mapel->num_rows > 0) {
                                        while ($row = $result_mapel->fetch_assoc()) {
                                    ?>
                                            <li><a class="dropdown-item <?php echo $mapelid == $row['id_mapel'] ? "bg-primary text-white" : ""; ?>" data-mapel="<?php echo $row['id_mapel'] ?>" href="#"><?php echo $row['nama_mapel'] ?></a></li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if ($mapelid > 0) {
                            $nilai_siswa = $nilai->get_nilai($mapelid);
                            if ($nilai_siswa) {
                                $row = $nilai_siswa->fetch_assoc();
                                if ($nilai_siswa->num_rows === 0) {
                                    echo "Belum Ada Nilai";
                                    $aksi = "tambah";
                                } else {
                                    $id_nilai = $row['id_nilai'];
                                    $aksi = "ubah";
                                }
                        ?>

                                <?php
                                if (isset($_GET['ubah-nilai'])) {
                                    if ($_GET['ubah-nilai'] == "berhasil") {
                                ?>
                                        <div class="alert alert-success" role="alert">
                                            Nilai berhasil diubah!
                                        </div>
                                    <?php
                                    } else if ($_GET['ubah-nilai'] == "gagal") {
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Nilai gagal diubah!
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                                <?php
                                if (isset($_GET['tambah-nilai'])) {
                                    if ($_GET['tambah-nilai'] == "berhasil") {
                                ?>
                                        <div class="alert alert-success" role="alert">
                                            Nilai berhasil ditambahkan!
                                        </div>
                                    <?php
                                    } else if ($_GET['tambah-nilai'] == "gagal") {
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Nilai gagah ditambahkan!
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <div class="mb-3">
                                    <label for="nilaiSiswaCP1" class="form-label">CP1</label>
                                    <input type="number" name="nilaicp1" min="0" max="100" class="form-control" id="nilaiSiswaCP1" value="<?php echo $row['cp1']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilaiSiswaCP2" class="form-label">CP2</label>
                                    <input type="number" name="nilaicp2" min="0" max="100" class="form-control" id="nilaiSiswaCP2" value="<?php echo $row['cp2']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilaiSiswaCP3" class="form-label">CP3</label>
                                    <input type="number" name="nilaicp3" min="0" max="100" class="form-control" id="nilaiSiswaCP3" value="<?php echo $row['cp3']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilaiSiswaCP4" class="form-label">CP4</label>
                                    <input type="number" name="nilaicp4" min="0" max="100" class="form-control" id="nilaiSiswaCP4" value="<?php echo $row['cp4']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilaiSiswaUTS" class="form-label">UTS</label>
                                    <input type="number" name="nilaiuts" min="0" max="100" class="form-control" id="nilaiSiswaUTS" value="<?php echo $row['uts']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilaiSiswaUAS" class="form-label">UAS</label>
                                    <input type="number" name="nilaiuas" min="0" max="100" class="form-control" id="nilaiSiswaUAS" value="<?php echo $row['uas']; ?>">
                                    <div class="invalid-feedback">
                                        Masukkan nilai dari 0 hingga 100
                                    </div>
                                </div>
                                <input type="hidden" name="aksi" id="aksinilai" value="<?php echo $aksi; ?>">
                                <input type="hidden" name="id_mapel" id="id_mapel" value="<?php echo $mapelid; ?>">
                                <input type="hidden" name="nis" id="nis" value="<?php echo $siswaid; ?>">
                                <div class="konten_ubah_nilai_opsi">
                                    <button onclick="window.location.replace('daftar-nilai'); return false;" type="button" class="btn btn-danger">Batalkan</button>
                                    <button type="submit" name="simpan-nilai" class="btn btn-primary d-inline-flex align-items-center">Simpan <i class='bx bx-save'></i></button>
                                </div>
                    </form>

        <?php
                            }
                        }
                    }

        ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var current_nis = '<?php echo $siswaid ?>';

        $('#dropdown-mapel a').on('click', function() {
            var txt = ($(this).data('mapel'));
            var link = "./ubah-nilai?&nis=" + current_nis + "&mapel=" + txt;
            console.log(link)
            window.open(link, "_self");
        });
    </script>
</body>

</html>