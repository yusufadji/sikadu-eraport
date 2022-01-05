<?php

require_once dirname(__FILE__) . '/../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('location: logout');
    exit();
}

$nip = $_SESSION['id'];
$login_as = $_SESSION['login_as'];

if (!isset($_SESSION['login_as']) || $_SESSION['login_as'] != "admin") {
    header('location: ../index');
    exit();
}

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
