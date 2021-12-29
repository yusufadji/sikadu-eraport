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
} else{
    if ($_SESSION['login_as'] != "guru") {
        header('location: ../index.php');
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
$offset = ($page_no-1) * $records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$result = $conn->query("SELECT COUNT(*) As total_records FROM siswa WHERE id_kelas = $kelas_id");
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
                    <a href="index.html">
                        <span class="icon"><i class='bx bx-grid-alt'></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-siswa.html">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <span class="title">Daftar Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-kelas.html">
                        <span class="icon"><i class='bx bx-door-open'></i></span>
                        <span class="title">Daftar Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-mapel.html">
                        <span class="icon"><i class='bx bx-book-alt'></i></span>
                        <span class="title">Daftar Mapel</span>
                    </a>
                </li>
                <li class="hovered">
                    <a href="daftar-nilai.html">
                        <span class="icon"><i class='bx bx-book-add'></i></span>
                        <span class="title">Daftar Nilai</span>
                    </a>
                </li>
                <li>
                    <a href="pesan.html">
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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA"
                    alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                Daftar Nilai
            </h2>
            <div class="konten_isi">
                <div class="konten_pengaturan">
                    <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuKelas"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Kelas
                        </a>
                        <ul class="dropdown-menu" id="dropdown-kelas" aria-labelledby="dropdownMenuKelas">
                            <?php 
                            $result_kelas = $conn->query("SELECT * FROM kelas WHERE nip = '$userid'");
                            if ($result_kelas && $result_kelas->num_rows > 0) {
                                while($row = $result_kelas->fetch_assoc()){
                            ?>
                            <li><a class="dropdown-item" data-kelas="<?php echo $row['id_kelas'] ?>" href="#"><?php echo $row['nama_kelas'] ?></a></li>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $result_siswa = $conn->query("SELECT * FROM siswa WHERE id_kelas = $kelas_id LIMIT $records_per_page OFFSET $offset");
                            $no = 1;
                            if ($result_siswa && $result_siswa->num_rows > 0) {
                                while($row = $result_siswa->fetch_assoc()){
                            
                            
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nis']; ?></td>
                                <td><?php echo $row['nama_siswa']; ?></td>
                                
                                <td class="aksi"><a href="ubah-nilai.html"><button type="button"
                                            class="btn btn-primary btn-sm">Ubah nilai <i
                                                class='bx bx-pencil'></i></button></a>
                                </td>
                            </tr>
                            <?php 
                                } //end while
                            } //endif
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="konten_nav">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </script>
        <script src="../assets/js/main.js"></script>
</body>

</html>