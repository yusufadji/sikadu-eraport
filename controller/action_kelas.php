<?php
require_once dirname(__FILE__) . '/../model/kelas.php';

if (isset($_POST['tambah-kelas'])) {
    $namakelas = $_POST['namaKelas'];
    $nipwali = $_POST['waliKelas'];
    $kelas = new Kelas();
    $result = $kelas->tambah_kelas($nipwali, $namakelas);
    var_dump($result);
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }
    header("location: ../admin/data-kelas?status=$status");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-kelas");
}

if (isset($_POST['ubah-kelas'])) {
    $idkelas = $_POST['id-kelas'];
    $namakelas = $_POST['namaKelas'];
    $nipwali = $_POST['waliKelas'];
    $kelas = new Kelas();
    $result = $kelas->ubah_kelas($idkelas, $nipwali, $namakelas);
    var_dump($result);
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }
    header("location: ../admin/data-kelas?status=$status");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-kelas");
}
