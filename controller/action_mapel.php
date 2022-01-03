<?php
require_once dirname(__FILE__) . '/../model/mapel.php';

if (isset($_POST['tambah-mapel'])) {
    $namamapel = $_POST['namaMapel'];
    $nip = $_POST['guruPengampu'];
    $mapel = new Mapel();
    $result = $mapel->tambah_mapel($nip, $namamapel);
    var_dump($result);
    if ($result) {
        $status = "sukses";
    } else {
        $status = "gagal";
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: ../admin/data-mapel");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-mapel");
}

if (isset($_POST['ubah-mapel'])) {
    $idmapel = $_POST['idMapel'];
    $namamapel = $_POST['namaMapel'];
    $nipwali = $_POST['guruPengampu'];
    $mapel = new Mapel();
    $result = $mapel->ubah_mapel($idmapel, $nipwali, $namamapel);
    var_dump($result);
    if ($result) {
        $status = "sukses";
    } else {
        $status = "gagal";
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: ../admin/data-mapel");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-mapel");
}
