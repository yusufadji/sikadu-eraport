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
                <li class="hovered">
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
                Ubah Data Siswa
            </h2>
            <div class="konten_isi">
                <?php
                $result_siswa = $conn->query("SELECT * FROM siswa WHERE nis = $siswaid LIMIT 1");
                if ($result_siswa && $result_siswa->num_rows > 0) {
                    while ($row = $result_siswa->fetch_assoc()) {
                ?>
                        <form action="../controller/action_siswa" method="post" class="konten_ubah_nilai was-validated">
                            <div class="mb-3">
                                <label for="nisSiswa" class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" id="nisSiswa" required value="<?php echo $row['nis']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan NIS Siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="namaSiswa" class="form-label">Nama siswa</label>
                                <input type="text" name="nama" class="form-control" id="namaSiswa" required value="<?php echo $row['nama_siswa']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan nama siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jkSiswa" class="form-label">Jenis kelamin</label>
                                <select name="jenkel" class="form-select" id="jkSiswa" required value="<?php echo $row['jenis_kelamin']; ?>">
                                    <option value="Laki-laki" selected>Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <div class="invalid-feedback">
                                    Pilih jenis kelamin siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalLahirSiswa" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggallahir" class="form-control" id="tanggalLahirSiswa" required value="<?php echo $row['tanggal_lahir']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan tanggal lahir siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamatSiswa" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamatSiswa" rows="3" required><?php echo $row['alamat']; ?></textarea>
                                <div class="invalid-feedback">
                                    Masukkan alamat siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="emailSiswa" class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control" id="emailSiswa" placeholder="name@example.com" required value="<?php echo $row['email']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan alamat email siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="noTelpSiswa" class="form-label">Nomor Telepon</label>
                                <input type="number" name="telepon" class="form-control" id="noTelpSiswa" placeholder="08123456789" required value="<?php echo $row['no_telp']; ?>">
                                <div class="invalid-feedback">
                                    Masukkan nomor telepon siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="agamaSiswa" class="form-label">Agama</label>
                                <select name="agama" class="form-select" id="agamaSiswa" required value="<?php echo $row['agama']; ?>">
                                    <option value="Buddha" selected>Buddha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghuchu">Konghuchu</option>
                                    <option value="Kristen">Kristen</option>
                                </select>
                                <div class="invalid-feedback">
                                    Masukkan agama siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kelasSiswa" class="form-label">Kelas</label>
                                <select name="kelas" class="form-select" id="kelasSiswa" required value="<?php echo $row['id_kelas']; ?>">
                                    <?php
                                    $result_kelas = $conn->query("SELECT * FROM kelas");
                                    if ($result_kelas && $result_kelas->num_rows > 0) {
                                        $no = 1;
                                        while ($row = $result_kelas->fetch_assoc()) {
                                            echo "
                                    <option value='${row['id_kelas']}'>${row['nama_kelas']}</option>
                                ";
                                            $no++;
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Masukkan kelas siswa
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="passwordSiswa" class="form-label">Password</label>
                                <input type="password" name="passsiswa" class="form-control" id="passwordSiswa" required>
                                <div class="invalid-feedback">
                                    Masukkan password akun siswa
                                </div>
                            </div>
                            <div class="konten_ubah_nilai_opsi">
                                <button onclick="window.location.replace('../admin/data-siswa'); return false;" type="button" class="btn btn-danger">Batalkan</button>
                                <button type="submit" name="ubah-siswa" class="btn btn-primary">Ubah Data</button>
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