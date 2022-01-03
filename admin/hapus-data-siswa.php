<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    global $conn;
    $query = "DELETE FROM siswa WHERE nis='$nis'";
    $result = $conn->query($query);
    if ($result) {
        return true;
    } else {
        return false;
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: data-siswa");
} else {
    header('location: data-siswa');
}
