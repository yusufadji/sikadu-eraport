<?php 

session_start();
session_unset();
session_destroy();
setcookie("id", "", time()-(30*60));
setcookie("kodenuklir", "", time()-(30*60));
header("location: login/siswa")
?>