<?php
require_once dirname(__FILE__) . '/../connection.php';
session_start();

if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $id_admin = $_COOKIE['id'];
    $_SESSION['login_as'] = $login_as;
} else {
    $id_admin = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}

if (!isset($_SESSION['login_as'])) {
    header('location: ../index');
} else {
    if ($_SESSION['login_as'] != "admin") {
        header('location: ../index');
    }
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

if (isset($_GET['id-kelas'])) {
    $kelasid = $_GET['id-kelas'];
} else {
    header('location: data-kelas');
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
                <li class="hovered">
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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA" alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                Ubah Data Kelas
            </h2>
            <div class="konten_isi">
                <?php
                $result_kelas = $conn->query("SELECT * FROM kelas WHERE id_kelas = $kelasid LIMIT 1");
                if ($result_kelas && $result_kelas->num_rows > 0) {
                    while ($row = $result_kelas->fetch_assoc()) {
                ?>
                        <form id="formulir" action="../controller/action_kelas" class="konten_ubah_nilai was-validated" method="post">
                            <div class="mb-3">
                                <label for="namaKelas" class="form-label">Nama Kelas</label>
                                <input type="text" required name="namaKelas" class="form-control" id="namaKelas" value="<?php echo $row['nama_kelas']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan nama kelas
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="waliKelas" class="form-label">NIP Wali Kelas</label>
                                <select name="waliKelas" class="form-select" id="waliKelas" required>
                                    <?php
                                    $result_guru = $conn->query("SELECT * FROM guru");
                                    if ($result_guru && $result_guru->num_rows > 0) {
                                        $no = 1;
                                        while ($row = $result_guru->fetch_assoc()) {
                                            echo "
                                                <option value='${row['nip']}'>${row['nip']} - ${row['nama_guru']}</option>
                                            ";
                                            $no++;
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Masukkan NIP Wali kelas
                                </div>
                            </div>
                            <input type="hidden" name="id-kelas" value="<?php echo $kelasid ?>">
                            <div class="konten_ubah_nilai_opsi">
                                <button onclick="window.location.replace('../admin/data-kelas'); return false;" type="button" class="btn btn-danger">Batalkan</button>
                                <button type="submit" name="ubah-kelas" class="btn btn-primary">Ubah</button>
                            </div>
                        </form>
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