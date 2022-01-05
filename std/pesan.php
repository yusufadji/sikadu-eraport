<?php
require_once '../connection.php';
require_once '../model/siswa.php';
require_once '../controller/action_chat.php';

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

if (!isset($_SESSION['login_as']) || $_SESSION['login_as'] != "siswa") {
    header('location: ../index');
    exit();
}

$siswa = new Siswa();
$walikelas = $siswa->get_wali_kelas($nis);
if ($walikelas != null) {
    $nip_walikelas = $walikelas['nip'];
    $nama_walikelas = $walikelas['nama_guru'];
    if ($walikelas['jenis_kelamin'] == "Laki-laki") {
        $prefix_nama = "Pak ";
    } else {
        $prefix_nama = "Bu ";
    }
} else {
    $tidak_tersedia = true;
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
                    <a href="profil">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <span class="title">Profil</span>
                    </a>
                </li>
                <li class="hovered">
                    <a href="#">
                        <span class="icon"><i class='bx bx-chat'></i></span>
                        <span class="title">Pesan</span>
                    </a>
                </li>
                <li>
                    <a href="prestasi">
                        <span class="icon"><i class='bx bxs-graduation'></i></span>
                        <span class="title">Prestasi</span>
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
    <div class="main" style="height: 100%;">
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
                Hubungi Wali Kelas
            </h2>
            <?php
            if (isset($tidak_tersedia) && $tidak_tersedia = true) {
                echo "Tidak tersedia!";
            } else {
            ?>
                <div class="konten_isi" style="height: 90%;">
                    <div class="chat-container" style="height: 100%;">
                        <div class="chat-list">

                        </div>
                        <div class="chat d-flex flex-column m-3 p-0">
                            <div class="card-header d-flex align-items-center">

                                <span class="chat-header-name mx-auto" data-id-walikelas="<?php echo $nip_walikelas ?>" id="nama-walikelas">
                                    <?php echo $prefix_nama . $nama_walikelas; ?>
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
                                    <button class="btn btn-primary input-group-text" id="send-button" onclick="send_message_to_wali_kelas('<?php echo $nis; ?>','<?php echo $nip_walikelas; ?>')"><i class='bx bx-send'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/chat.js"></script>
        <?php

        echo "<script> var id_siswa = '$nis'; var id_wali = '$nip_walikelas'; </script>";

        ?>
        <script>
            // cek pesan dari wali kelas tiap 3 detik
            setInterval(cekPesanDariWaliKelas, 3000, id_siswa, id_wali);
        </script>
</body>

</html>