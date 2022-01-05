<?php
require_once dirname(__FILE__) . '/../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: logout');
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
                Tambah Data Guru
            </h2>
            <div class="konten_isi">
                <form action="../controller/action_guru" method="post" class="konten_ubah_nilai was-validated">
                    <div class="mb-3">
                        <label for="nipGuru" class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" id="nipGuru" required>
                        <div class="invalid-feedback">
                            Masukkan NIP guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="namaGuru" class="form-label">Nama guru</label>
                        <input type="text" name="nama" class="form-control" id="namaGuru" required>
                        <div class="invalid-feedback">
                            Masukkan nama guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jkGuru" class="form-label">Jenis kelamin</label>
                        <select name="jenkel" class="form-select" id="jkGuru" required>
                            <option value="Laki-laki" selected>Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <div class="invalid-feedback">
                            Masukkan jenis kelamin guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalLahirGuru" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggallahir" class="form-control" id="tanggalLahirGuru" required>
                        <div class="invalid-feedback">
                            Masukkan tanggal lahir guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamatGuru" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamatGuru" rows="3" required></textarea>
                        <div class="invalid-feedback">
                            Masukkan alamat guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="emailGuru" class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="emailGuru" placeholder="name@example.com" required>
                        <div class="invalid-feedback">
                            Masukkan alamat email guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="noTelpGuru" class="form-label">Nomor Telepon</label>
                        <input type="number" name="telepon" class="form-control" id="noTelpGuru" placeholder="08123456789" required>
                        <div class="invalid-feedback">
                            Masukkan nomor telepon guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="agamaGuru" class="form-label">Agama</label>
                        <select name="agama" class="form-select" id="agamaGuru" required>
                            <option value="Buddha" selected>Buddha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Islam">Islam</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Konghuchu">Konghuchu</option>
                            <option value="Kristen">Kristen</option>
                        </select>
                        <div class="invalid-feedback">
                            Masukkan agama guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="statusGuru" class="form-label">Status</label>
                        <select name="status" class="form-select" id="statusGuru" required>
                            <option value="Pegawai Negeri Sipil" selected>Pegawai Negeri Sipil</option>
                            <option value="Guru Tidak Tetap">Guru Tidak Tetap</option>
                            <option value="Guru Tetap Yayasan">Guru Tetap Yayasan</option>
                        </select>
                        <div class="invalid-feedback">
                            Masukkan status guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordGuru" class="form-label">Password</label>
                        <input type="password" name="passguru" class="form-control" id="passwordGuru" required>
                        <div class="invalid-feedback">
                            Masukkan password akun guru
                        </div>
                    </div>
                    <div class="konten_ubah_nilai_opsi">
                        <button onclick="window.location.replace('../admin/data-guru'); return false;" type="button" class="btn btn-danger">Batalkan</button>
                        <button name="tambah-guru" type="submit" class="btn btn-success">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>