<?php

require_once "../connection.php";
require_once "../model/admin.php";

session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ke index jika sudah login
if (isset($_COOKIE['id'])) {
    $_SESSION['login'] = true;
}

if (isset($_SESSION['login'])) {
    header("location: ../index");
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $admin = new Admin();

    $verify = $admin->cek_login_admin($email, $password);

    if ($verify) {
        $info_admin = $admin->get_detail_admin_by_email($email);
        $adminid = $info_admin['id_admin'];
        $email = $info_admin['email'];
        // set session
        $_SESSION['login'] = true;
        $_SESSION['id'] = $adminid;
        $_SESSION['login_as'] = 'admin';
        header("location: ../index");
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

    <title>Login Admin</title>
</head>

<body>

    <div class="login">
        <div class="login_content">
            <div class="login_img">
                <img src="../assets/img/knowledge-book-education-learning-books-svgrepo-com.svg" alt="">
            </div>
            <div class="login_forms">
                <form action="./admin" class="login_register" id="login-in" method="POST">
                    <h1 class="login_title">ADMIN</h1>
                    <?php 
                    if (isset($status) && $status == "gagal") {
                       echo "
                        <div class='alert alert-danger' role='alert'>Login gagal. Silahkan ulangi!</div>
                       ";
                    }
                    ?>
                    <div class="login_box">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Email" class="login_input" name="email">
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

</body>

</html>