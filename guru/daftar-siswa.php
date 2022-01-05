<?php
require_once dirname(__FILE__) . '/../connection.php';
require_once dirname(__FILE__) . '/../model/kelas.php';
require_once dirname(__FILE__) . '/../model/siswa.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: ../logout');
    exit();
}

$nip = $_SESSION['id'];
$login_as = $_SESSION['login_as'];

if (!isset($_SESSION['login_as']) || $_SESSION['login_as'] != "guru") {
    header('location: ../index');
    exit();
}

if (!isset($_GET['p'])) {
    $page_no = 1;
} else {
    $page_no = $_GET['p'];
}
if (!isset($_GET['kls'])) {
    $kelas_id = 1;
} else {
    $kelas_id = $_GET['kls'];
}

$kelas = new Kelas();
// pagination
$records_per_page = 30;
$offset = ($page_no - 1) * $records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$total_records = $kelas->get_jumlah_siswa_kelas($kelas_id);
$total_no_of_pages = ceil($total_records / $records_per_page);
$second_last = $total_no_of_pages - 1;
$adjacents = "2";

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
                    <a href="index">
                        <span class="icon"><i class='bx bx-grid-alt'></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="hovered">
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
                <?php
                if (isset($_SESSION['is_walikelas']) && $_SESSION['is_walikelas'] == true) {
                ?>
                    <li>
                        <a href="pesan">
                            <span class="icon"><i class='bx bx-chat'></i></span>
                            <span class="title">Pesan</span>
                        </a>
                    </li>
                <?php
                }
                ?>
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
                Daftar Siswa
            </h2>
            <div class="konten_isi">
                <div class="konten_pengaturan">
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuKelas" data-bs-toggle="dropdown" aria-expanded="false">
                            Kelas
                        </a>
                        <ul class="dropdown-menu" id="dropdown-kelas" aria-labelledby="dropdownMenuKelas">
                            <?php
                            $result_kelas = $kelas->get_daftar_kelas();
                            if ($result_kelas && $result_kelas->num_rows > 0) {
                                while ($row = $result_kelas->fetch_assoc()) {
                            ?>
                                    <li><a class="dropdown-item <?php echo $kelas_id == $row['id_kelas'] ? "bg-primary text-white" : ""; ?>" data-kelas="<?php echo $row['id_kelas'] ?>" href="#"><?php echo $row['nama_kelas'] ?></a></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="konten_table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Induk Siswa</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result_siswa = $siswa->get_daftar_siswa_by_kelas($kelas_id, $records_per_page, $offset);
                            $no = 1;
                            if ($result_siswa && $result_siswa->num_rows > 0) {
                                while ($row = $result_siswa->fetch_assoc()) {

                            ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $row['nis'] ?></td>
                                        <td><?php echo $row['nama_siswa'] ?></td>
                                        <td><?php echo $row['jenis_kelamin'] ?></td>
                                    </tr>
                            <?php
                                    $no++;
                                } //end while
                            } // endif
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="konten_nav">
                <nav aria-label="Page Navigation">
                    <ul class="pagination">
                        <?php
                        if ($total_no_of_pages > 1) {
                        ?>
                            <li class="page-item"><a class="page-link" href="<?php echo "?kls=$kelas_id&$previous_page"; ?>">Previous</a></li>
                            <?php

                            for ($i = 1; $i <= $total_no_of_pages; $i++) {
                            ?>
                                <li class='page-item <?php echo $i == $page_no ? "active" : "" ?>'><a class='page-link' href='<?php echo "?kls=$kelas_id&p=$i"; ?>'><?php echo $i; ?></a></li>
                            <?php

                            }

                            ?>
                            <li class="page-item"><a class="page-link" href="<?php echo "?kls=$kelas_id&$next_page" ?>">Next</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/main.js"></script>
        <script>
            $('#dropdown-kelas a').on('click', function() {
                var txt = ($(this).data('kelas'));
                window.open("./daftar-siswa?kls=" + txt, "_self")
            });
        </script>
</body>

</html>