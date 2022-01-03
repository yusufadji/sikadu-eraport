<?php 
require_once dirname(__FILE__) . '/../connection.php';
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
} else{
    if ($_SESSION['login_as'] != "guru") {
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
$offset = ($page_no-1) * $records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$result = $conn->query("SELECT COUNT(*) As total_records FROM chats INNER JOIN siswa ON siswa.nis = chats.murid_id WHERE guru_id = $nip GROUP BY murid_id");
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
                <li class="hovered">
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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA"
                    alt="user">
            </div>
        </div>

        <div class="konten">
            <h2 class="konten_title">
                Pesan dari Siswa
            </h2>
            <div class="konten_isi">
                <div class="konten_pengaturan">
                    
                </div>
                <div class="konten_table table-responsive">
                    <table class="daftar_chat table table-bordered">
                        <tbody>
                            <?php 
                            $result_siswa = $conn->query("CALL get_list_chat_siswa('$nip')");
                            if ($result_siswa && $result_siswa->num_rows > 0) {
                                while($row = $result_siswa->fetch_assoc()){
                                    $nis = $row['murid_id'];
                                    $kls = $row['nama_kelas']
                            ?>
                            <tr>
                                <td onclick="location.href='pesan?nis=<?php echo $nis ?>'">
                                
                                <i class='bx bx-message-dots m-1'></i>
                                <div class="mx-1">
                                <h5><?php echo $row['nama_siswa'] ?></h5>
                                    <?php echo $nis . " • " . $kls; ?>
                                </div>
                                
                                </td>
                            </tr>
                            <?php 
                                
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
                        
                            for ($i=1; $i <= $total_no_of_pages; $i++) { 
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

</body>

</html>