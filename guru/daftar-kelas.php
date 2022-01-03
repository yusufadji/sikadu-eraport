<?php 
require_once '../connection.php';
session_start();

if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $nip = $_COOKIE['id'];
    $_SESSION['login_as'] = $login_as;
} else {
    $nip = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}

if (!isset($_SESSION['login_as'])) {
    header('location: ../index');
} else {
    if ($_SESSION['login_as'] != "guru") {
        header('location: ../index');
    }
}

if (!isset($_GET['p'])) {
    $page_no = 1;
} else {
    $page_no = $_GET['p'];
}

$records_per_page = 10;
$offset = ($page_no-1) * $records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$result = $conn->query("SELECT COUNT(*) As total_records FROM kelas");
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
                    <a href="index">
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
                <li class="hovered">
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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA"
                    alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                Daftar Kelas
            </h2>
            <div class="konten_isi table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $result_kelas = $conn->query("SELECT * FROM kelas LIMIT $records_per_page OFFSET $offset");
                        if ($result_kelas && $result_kelas->num_rows > 0) {
                            $no = 1;
                            while($row = $result_kelas->fetch_assoc()){
                                $id_kls = $row['id_kelas'];
                                $result_jml = $conn->query("SELECT COUNT(*) AS total_siswa FROM siswa WHERE id_kelas = $id_kls");
                                $jml = $result_jml->fetch_assoc();
                                echo "
                                <tr>
                                    <td>$no</td>
                                    <td>${row['nama_kelas']}</td>
                                    <td>${jml['total_siswa']} siswa</td>
                                </tr>
                                ";
                                $no++;
                            }
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="konten_nav">
            <nav aria-label="Page Navigation">
                    <ul class="pagination">
                        <?php 
                        if ($total_no_of_pages > 1) {
                         ?>
                        <li class="page-item"><a class="page-link" href="<?php echo "?p=$previous_page"; ?>">Previous</a></li>
                        <?php 
                        
                            for ($i=1; $i <= $total_no_of_pages; $i++) { 
                        ?>
                        <li class='page-item <?php echo $i == $page_no ? "active" : "" ?>'><a class='page-link' href='<?php echo "?p=$i"; ?>'><?php echo $i; ?></a></li>
                        <?php
                            
                            }
                        
                        ?>
                        <li class="page-item"><a class="page-link" href="<?php echo "?p=$next_page" ?>">Next</a></li>
                        <?php 
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </script>
        <script src="../assets/js/main.js"></script>
</body>

</html>