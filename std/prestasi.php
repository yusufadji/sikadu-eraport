<?php

require_once '../connection.php';
require_once '../model/nilai.php';
session_start();

if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $userid = $_COOKIE['id'];
    $kodenuklir = $_COOKIE['kodenuklir'];
} else {
    $userid = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}
if (!isset($_SESSION['login_as'])) {
    header('location: ../index');
} else {
    if ($_SESSION['login_as'] != "siswa") {
        header('location: ../index');
    }
}

$nilai = new Nilai($userid);

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
                    <a href="profil">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <span class="title">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="pesan">
                        <span class="icon"><i class='bx bx-chat'></i></span>
                        <span class="title">Pesan</span>
                    </a>
                </li>
                <li class="hovered">
                    <a href="#">
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
                Prestasi
            </h2>
            <div class="konten_isi">
                <div class="konten_pengaturan">

                    <div class="dropdown m-1">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuTA" data-bs-toggle="dropdown" aria-expanded="false">
                            Tahun Ajaran
                        </a>
                        <ul id="dropdown-tahunajaran" class="dropdown-menu" aria-labelledby="dropdownMenuTA">
                            <?php
                            $result_ta = $nilai->get_tahun_ajaran();
                            while ($row = $result_ta->fetch_assoc()) {
                            ?>
                                <li><a class="dropdown-item" data-tahunajaran="<?php echo $row['tahun_ajaran']; ?>" href="#"><?php echo substr_replace($row['tahun_ajaran'], '/', 4, 0); ?></a></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="dropdown m-1">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuSmt" data-bs-toggle="dropdown" aria-expanded="false">
                            Semester
                        </a>

                        <ul class="dropdown-menu" id="dropdown-semester" aria-labelledby="dropdownMenuSmt">
                            <li><a class="dropdown-item" data-semester="1" href="#">Semester Ganjil</a></li>
                            <li><a class="dropdown-item" data-semester="2" href="#">Semester Genap</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-primary m-1" id="btn-lihat" onclick="lihat_data()">Lihat</button>
                    <div class="spinner-border spinner-border-sm text-primary" role="status" id="loading-status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="konten_table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mapel</th>
                                <th>CP1</th>
                                <th>CP2</th>
                                <th>CP3</th>
                                <th>CP4</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-body-prestasi">
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <?php 
        echo "<script>var user_id = '$userid';</script>";
        ?>
        <script>
            var selected_TA = 0;

            $('#dropdown-tahunajaran a').on('click', function() {
                var txt = ($(this).data('tahunajaran'));
                selected_TA = txt;
                $('#dropdownMenuTA').text($(this)[0].text);
            });

            var selected_semester = 1;
            $('#dropdown-semester a').on('click', function() {
                var txt = ($(this).data('semester'));
                selected_semester = txt;
                $('#dropdownMenuSmt').text($(this)[0].text);
                console.log($(this)[0].text)
            });

            function lihat_data() {
                $.ajax({
                    type: "POST",
                    url: "../controller/action_nilai",
                    data: {
                        lihat_nilai: "",
                        nis: user_id,
                        tahun_ajaran: selected_TA,
                        semester: selected_semester
                    },
                    beforeSend: function() {
                        $("#loading-status").show()
                    },
                    success: function(response) {
                        $("#loading-status").hide()
                        $("#tabel-body-prestasi").html("");
                        resp_data = response.data;
                        resp_data.forEach(element => {
                            $("#tabel-body-prestasi").append(
                                `<tr>
                        <td>${element.nama_mapel}</td>
                        <td>${element.cp1}</td>
                        <td>${element.cp2}</td>
                        <td>${element.cp3}</td>
                        <td>${element.cp4}</td>
                        <td>${element.uts}</td>
                        <td>${element.uas}</td>
                        <td>${element.nilai_akhir}</td>
                    </tr>`
                            )
                        });
                    },
                    error: function(response) {
                        console.log(response)
                    },
                });
            }
        </script>
</body>

</html>