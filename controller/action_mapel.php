<?php
require_once dirname(__FILE__) . '/../model/mapel.php';

if (isset($_POST['tambah-mapel'])) {
    $namamapel = $_POST['namaMapel'];
    $nip = $_POST['guruPengampu'];
    $mapel = new Mapel();
    $result = $mapel->tambah_mapel('', $nip, $namamapel);
    if ($result) {
        $status = "sukses";
    } else {
        $status = "gagal";
    }
    header("location: ../admin/tambah-data-mapel&status=$status");
}
?>