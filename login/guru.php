<?php

require_once "../connection.php";
require_once "../model/guru.php";

session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['login'])){
    header("location: ../index");
}

if(isset($_POST["login"])){
    $nip = $_POST["nip"];
    $password = $_POST["password"];
    
    $guru = new Guru();
    $verifikasi = $guru->cek_login_guru($nip, $password);
    
    if ($verifikasi) {
        $info_guru = $guru->get_detail_guru($nip);
        // set session
        $_SESSION['login'] = true;
        $_SESSION['id'] = $info_guru['nip'];
        $_SESSION['login_as'] = 'guru';
        header("location: ../index");
        exit();
    } else {
        $status = "gagal";
    }    
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style-login.css">
    <script src="https://kit.fontawesome.com/158e244731.js" crossorigin="anonymous"></script>

    <title>Login Guru</title>
</head>

<body>
    <div class="login">
        <div class="login_content">
            <div class="login_img">
                <img src="../assets/img/knowledge-book-education-learning-books-svgrepo-com.svg" alt="">
            </div>
            <div class="login_forms">
                <form action="./guru" class="login_register" id="login-in" method="POST">
                    <h1 class="login_title">GURU</h1>
                    <?php 
                    if (isset($status) && $status == "gagal") {
                       echo "
                        <div class='alert alert-danger' role='alert'>Login gagal. Silahkan ulangi!</div>
                       ";
                    }
                    ?>
                    <div class="login_box">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nomor Induk Pegawai" class="login_input" name="nip">
                    </div>

                    <div class="login_box">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" class="login_input" name="password">
                    </div>
                    <div class="login_box">
                        <button type="submit" href="#" class="login_button" id="login" name="login">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>