<?php 

require_once '../connection.php';
require_once '../model/siswa.php';

session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ke index jika sudah login
if (isset($_COOKIE['id'])) {
    $_SESSION['login'] = true;
}

if(isset($_SESSION['login'])){
    header("location: ../index");
}

if(isset($_POST["login"])){
    $nis = $_POST["nis"];
    $password = $_POST["password"];
    
    $siswa = new Siswa();
    $verifikasi = $siswa->cek_login_siswa($nis, $password);
    
    if ($verifikasi) {
        $info_siswa = $siswa->get_detail_siswa($nis);
        if (isset($_POST["remember"])) {
            setcookie("id", $info_siswa['nis'], time()+(30*60));
            setcookie("kodenuklir", hash('sha256', $info_siswa['email']), time()+(30*60));
            setcookie("login_as", 'siswa');
        }
        // set session
        $_SESSION['login'] = true;
        $_SESSION['id'] = $info_siswa['nis'];
        $_SESSION['login_as'] = 'siswa';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/158e244731.js" crossorigin="anonymous"></script>

    <title>Login Siswa</title>
</head>
<body>
    <div class="login">
        <div class="login_content">
            <div class="login_img">
                <img src="../assets/img/knowledge-book-education-learning-books-svgrepo-com.svg" alt="">
            </div>
            <div class="login_forms">
                <form action="./siswa" class="login_register" id="login-in" method="POST">
                    <h1 class="login_title">SISWA</h1>
                    <?php 
                    if (isset($status) && $status == "gagal") {
                       echo "
                        <div class='alert alert-danger' role='alert'>Login gagal. Silahkan ulangi!</div>
                       ";
                    }
                    ?>
                    <div class="login_box">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nomor Induk Siswa" class="login_input" name="nis">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>