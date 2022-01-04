<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['id-kelas'])) {
    $id_kelas = $_GET['id-kelas'];
    global $conn;
    $query = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
    $result = $conn->query($query);
    if ($result) {
        header("location: data-kelas");
        return true;
    } else {
        return false;
    }
} else {
    header('location: data-kelas');
}
