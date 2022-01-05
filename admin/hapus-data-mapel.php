<?php

require_once dirname(__FILE__) . '/../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_GET['id_mapel'])) {
    $id_mapel = $_GET['id_mapel'];
    global $conn;
    $query = "DELETE FROM mata_pelajaran WHERE id_mapel='$id_mapel'";
    $result = $conn->query($query);
    if ($result) {
        header("location: data-mapel");
        return true;
    } else {
        return false;
    }
} else {
    header('location: data-mapel');
}
