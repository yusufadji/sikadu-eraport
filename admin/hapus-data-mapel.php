<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['id_mapel'])) {
    $id_mapel = $_GET['id_mapel'];
    global $conn;
    $query = "DELETE FROM mata_pelajaran WHERE id_mapel='$id_mapel'";
    $result = $conn->query($query);
    if ($result) {
        return true;
        header("location: data-mapel");
    } else {
        return false;
    }
} else {
    header('location: data-mapel');
}
