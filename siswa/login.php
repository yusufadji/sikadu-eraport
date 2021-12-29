<?php 

require_once "../connection.php";

session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ke index.php jika sudah login
if (isset($_COOKIE['id'])) {
    $_SESSION['login'] = true;
}

if(isset($_SESSION['login'])){
    header("location: index.php");
}

if(isset($_POST["login"])){
    $nis = $_POST["nis"];
    $password = $_POST["password"];

    var_dump($nis);
    var_dump($password);
        
    $result = $conn->query("SELECT * FROM siswa WHERE nis = '$nis' LIMIT 1"); // TODO: nanti diganti dg stored procedure
    // $conn->next_result();
        
    if ($result) {
        if($result->num_rows === 1){
            $siswa = $result->fetch_assoc();
            $db_password = $siswa['password'];
            $siswaid = $siswa['nis'];
            $email = $siswa['email'];
            // $verif = password_verify($password, $db_password); nanti pake bcrypt

            if ($password == $db_password){
                echo "oke";
                // simpan cookie untuk 30 menit (30 mnt * 60 dtk)
                if (isset($_POST["remember"])) {
                    setcookie("id", $siswa, time()+(30*60));
                    setcookie("kodenuklir", hash('sha256', $email), time()+(30*60));
                    setcookie("login_as", 'siswa');
                }
                // set session
                $_SESSION['login'] = true;
                $_SESSION['id'] = $siswaid;
                $_SESSION['login_as'] = 'siswa';
                header("location: index.php");
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



    <title>Login Siswa</title>
</head>
<body>
    <div class="login">
        <div class="login_content">
            <div class="login_img">
                <img src="../assets/img/knowledge-book-education-learning-books-svgrepo-com.svg" alt="">
            </div>
            <div class="login_forms">
                <form action="./login.php" class="login_register" id="login-in" method="POST">
                    <h1 class="login_title">SISWA</h1>

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





    <script src="assets/js/main.js"></script>
</body>
</html>