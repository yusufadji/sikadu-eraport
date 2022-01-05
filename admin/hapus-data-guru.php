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

if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];
    global $conn;
    $query = "DELETE FROM guru WHERE nip='$nip'";
    $result = $conn->query($query);
    if ($result) {
        header("location: data-guru");
        return true;
    } else {
        return false;
    }
} else {
    header('location: data-guru');
}
