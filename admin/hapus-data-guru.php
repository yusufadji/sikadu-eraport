<?php

require_once dirname(__FILE__) . '/../connection.php';

if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];
    global $conn;
    $query = "DELETE FROM guru WHERE nip='$nip'";
    $result = $conn->query($query);
    if ($result) {
        return true;
    } else {
        return false;
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: data-guru");
} else {
    header('location: data-guru');
}
