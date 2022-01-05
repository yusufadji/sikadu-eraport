<?php
require_once dirname(__FILE__) . '/../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: ../logout');
    exit();
}

$userid = $_SESSION['id'];
$login_as = $_SESSION['login_as'];

if (!isset($_SESSION['login_as']) || $_SESSION['login_as'] != "admin") {
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
$records_per_page = 30;
$offset = ($page_no - 1) * $records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$result = $conn->query("SELECT COUNT(*) As total_records FROM guru");
$total_records = $result->fetch_assoc();
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $records_per_page);
$second_last = $total_no_of_pages - 1;
$adjacents = "2";

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Data Guru | E-Raport</title>
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

        <!-- card -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <?php
                    $result_guru = $conn->query("SELECT * FROM guru LIMIT $records_per_page OFFSET $offset");
                    if ($result_guru && $result_guru->num_rows > 0) {
                        $result_jml = $conn->query("SELECT COUNT(*) AS total_guru FROM guru");
                        $jml = $result_jml->fetch_assoc();
                        echo "<div class='numbers'>${jml['total_guru']}</div>";
                    }
                    ?>
                    <div class="cardName">Guru</div>
                </div>
                <div class="iconBx">
                    <i class='bx bx-user'></i>
                </div>
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                Data Guru
            </h2>
            <div class="konten_isi">
                    <?php
                        if (isset($_GET['status'])) {
                            if ($_GET['status'] == "berhasil") {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                Data berhasil diubah/ditambahkan!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";

                            } else if ($_GET['status'] == "gagal") {

                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Data gagal diubah/ditambahkan!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                            }
                        }
                    ?>
                <div class="konten_pengaturan">
                    <a href="tambah-data-guru"><button type="button" class="btn btn-success">Tambah
                            guru</button></a>
                </div>
                <div class="konten_table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Guru</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $result_guru = $conn->query("SELECT * FROM guru LIMIT $records_per_page OFFSET $offset");
                        if ($result_guru && $result_guru->num_rows > 0) {
                            $no = 1;
                            while ($row = $result_guru->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>$no</td>
                                    <td>${row['nip']}</td>
                                    <td>${row['nama_guru']}</td>
                                    <td>${row['alamat']}</td>
                                    <td>${row['email']}</td>
                                    <td>${row['no_telp']}</td>
                                    <td class='aksi'>
                                        <a href='ubah-data-guru?nip=${row['nip']}'><button type='button' data-bs-toggle='tooltip' class='btn btn-primary btn-sm' title='Ubah'><i class='bx bx-pencil'></i></button></a>
                                        <a href='hapus-data-guru?nip=${row['nip']}'><button type='button' data-bs-toggle='tooltip' class='btn btn-danger btn-sm' title='Hapus'><i class='bx bx-trash'></i></button></a>
                                    </td>
                                </tr>
                                ";
                                $no++;
                            }
                        }
                        ?>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="konten_nav">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        if ($total_no_of_pages > 1) {
                        ?>
                            <li class="page-item"><a class="page-link" href="<?php echo "?$previous_page"; ?>">Previous</a></li>
                            <?php

                            for ($i = 1; $i <= $total_no_of_pages; $i++) {
                            ?>
                                <li class='page-item <?php echo $i == $page_no ? "active" : "" ?>'><a class='page-link' href='<?php echo "?p=$i"; ?>'><?php echo $i; ?></a></li>
                            <?php

                            }

                            ?>
                            <li class="page-item"><a class="page-link" href="<?php echo "?$next_page" ?>">Next</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>