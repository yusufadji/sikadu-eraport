<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    global $conn;
    $query = "DELETE FROM siswa WHERE nis='$nis'";
    $result = $conn->query($query);
    if ($result) {
        header("location: data-siswa");
        return true;
    } else {
        return false;
    }
} else {
    header('location: data-siswa');
}
