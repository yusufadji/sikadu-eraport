<?php

require_once "../connection.php";

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

    var_dump($email);
    var_dump($password);

    $result = $conn->query("SELECT * FROM admin WHERE email = '$email' LIMIT 1"); // TODO: nanti diganti dg stored procedure
    // $conn->next_result();
    var_dump($result);

    if ($result) {
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            $db_password = $admin['password'];
            $adminid = $admin['id_admin'];
            $email = $admin['email'];
            // $verif = password_verify($password, $db_password); nanti pake bcrypt

            if ($password == $db_password) {

                // simpan cookie untuk 30 menit (30 mnt * 60 dtk)
                if (isset($_POST["remember"])) {
                    setcookie("id", $adminid, time() + (30 * 60));
                    setcookie("kodenuklir", hash('sha256', $email), time() + (30 * 60));
                    setcookie("login_as", 'guru');
                }
                // set session
                $_SESSION['login'] = true;
                $_SESSION['id'] = $adminid;
                $_SESSION['login_as'] = 'admin';
                header("location: ../index");
            } else {
                $status = "invalidlogin";
            }
        } else {
            $status = "invalidlogin";
        }
    } else {
        $status = "invalidlogin";
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
                <img src="assets/img/knowledge-book-education-learning-books-svgrepo-com.svg" alt="">
            </div>
            <div class="login_forms">
                <form action="./admin" class="login_register" id="login-in" method="POST">
                    <h1 class="login_title">ADMIN</h1>

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