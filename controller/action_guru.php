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
    $hashed_password = password_hash($passguru, PASSWORD_BCRYPT);
    $guru = new Data();
    $result = $guru->tambah_data_guru($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $status, $tanggallahir, $hashed_password);
    var_dump($result);
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }
    header("location: ../admin/data-guru?status=$status");
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
    $hashed_password = password_hash($passguru, PASSWORD_BCRYPT);
    $guru = new Data();
    $result = $guru->ubah_data_guru($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $status, $tanggallahir, $hashed_password);
    var_dump($result);
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }

    header("location: ../admin/data-guru?status=$status");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-guru");
}
