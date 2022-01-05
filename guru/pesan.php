<?php
require_once dirname(__FILE__) . '/../connection.php';
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

if (!isset($_GET['nis'])) {
    header('location: daftar-pesan');
    exit();
}
$nis = $_GET['nis'];

$siswa = new Siswa();
$nama_siswa = $siswa->get_nama_siswa($nis);
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
    <link rel="stylesheet" href="../assets/css/chat.css">
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

        <div class="konten" style="height: 100%; overflow: unset;">
            <h2 class="konten_title">
                <a href="./daftar-pesan" class="back-btn"><i class='bx bx-arrow-back'></i></a>
                Pesan dari <?php echo $nama_siswa; ?>
            </h2>
            <div class="konten_isi" style="height: 90%;">
                <div class="chat-container" style="height: 100%;">
                    <div class="chat-list">

                    </div>
                    <div class="chat d-flex flex-column m-3 p-0">
                        <div class="card-header d-flex align-items-center">

                            <span class="chat-header-name mx-auto" data-id-siswa="<?php echo $nis ?>" id="nama-siswa">
                                <?php echo $nama_siswa; ?>
                            </span>
                        </div>
                        <div class="chat-messages d-flex flex-column" id="chat-messages">
                            <div class="spinner-border spinner-border-sm text-primary" role="status" id="chat-loading">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                        </div>
                        <div class="card-footer bg-white">
                            <div class="input-group ">
                                <input id="input-pesan" type="text" class="form-control" placeholder="Chat di sini..." aria-label="Chat di sini..." aria-describedby="send-button">
                                <button class="btn btn-primary input-group-text" id="send-button" onclick="send_message_to_siswa('<?php echo $nis; ?>','<?php echo $nip; ?>')"><i class='bx bx-send'></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/chat.js"></script>
        <?php

        echo "<script> var id_siswa = '$nis'; var id_wali = '$nip'; </script>";

        ?>
        <script>
            $('#dropdown-kelas a').on('click', function() {
                var txt = ($(this).data('kelas'));
                window.open("./daftar-siswa?kls=" + txt, "_self")
            });


            // jalankan cekPesan setiap 1 detik
            setInterval(cekPesanDariSiswa, 3000, id_siswa, id_wali);
        </script>
</body>

</html>