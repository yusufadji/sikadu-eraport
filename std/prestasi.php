<?php

require_once '../connection.php';
session_start();

if (isset($_COOKIE['login_as'])) {
    $login_as = $_COOKIE['login_as'];
    $userid = $_COOKIE['id'];
    $kodenuklir = $_COOKIE['kodenuklir'];
} else {
    $userid = $_SESSION['id'];
    $login_as = $_SESSION['login_as'];
}

if ($login_as == "siswa") {
}
if (isset($_POST['tahun_ajaran'])) {
    $smt = $_POST['semester'];
    $ta = $_POST['tahun_ajaran'];
    $data = array();

    $result = $conn->query("SELECT * FROM raport INNER JOIN nilai ON raport.id_raport = nilai.id_raport INNER JOIN mata_pelajaran ON nilai.id_mapel = mata_pelajaran.id_mapel WHERE raport.nis = '51904100001' AND tahun_ajaran = $ta AND rapor_semester = $smt;");
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }
    $response = array(
        'status' => 200,
        'message' => "Success",
        'data' => $data
    );
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$result_ta = $conn->query("SELECT DISTINCT (tahun_ajaran) FROM raport WHERE nis = '$userid'");


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
                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiXyPi_rGT6jD0HngbJm7ynV-rF3rbepixGAznBNXQteWfrkWk1VvidfrFLeLr3E1slcwmf0jQ3ktsRI1Ga6xMOftHsDC1fbi9Oid8jOz0YX22jl6_i38Y5xbRuLrmoQm2O371YilOhD77YN1xeyibg4_B0qHWhOv24q9DoKzQokmiuruFKmPYKvX1zeA" alt="user">
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
                    url: "./prestasi",
                    data: {
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