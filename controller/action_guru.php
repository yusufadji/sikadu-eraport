<?php
require_once dirname(__FILE__) . '/../model/data.php';

if (isset($_POST['tambah-guru'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $agama = $_POST['agama'];
    $status = $_POST['status'];
    $passguru = $_POST['passguru'];
    // $walikelas = $_POST['walikelas'];
    $guru = new Data();
    $result = $guru->tambah_data_guru($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $status, $tanggallahir, $passguru);
    var_dump($result);
    if ($result) {
        $stats = "sukses";
    } else {
        $stats = "gagal";
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: ../admin/data-guru");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-guru");
}

if (isset($_POST['ubah-guru'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $agama = $_POST['agama'];
    $status = $_POST['status'];
    $passguru = $_POST['passguru'];
    // $walikelas = $_POST['walikelas'];
    $guru = new Data();
    $result = $guru->ubah_data_guru($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $status, $tanggallahir, $passguru);
    var_dump($result);
    if ($result) {
        $stats = "sukses";
    } else {
        $stats = "gagal";
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: ../admin/data-guru");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-guru");
}
