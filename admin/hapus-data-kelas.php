<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['id-kelas'])) {
    $id_kelas = $_GET['id-kelas'];
    global $conn;
    $query = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
    $result = $conn->query($query);
    if ($result) {
        return true;
    } else {
        return false;
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: data-kelas");
} else {
    header('location: data-kelas');
}
