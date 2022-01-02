<?php 
require_once dirname(__FILE__) . '/../model/nilai.php';

if (isset($_POST['simpan-nilai'])) {
    $aksi = $_POST['aksi'];
    $nis = $_POST['nis'];
    $id_mapel = $_POST['id_mapel'];
    $cp1 = $_POST['nilaicp1'];
    $cp2 = $_POST['nilaicp2'];
    $cp3 = $_POST['nilaicp3'];
    $cp4 = $_POST['nilaicp4'];
    $uts = $_POST['nilaiuts'];
    $uas = $_POST['nilaiuas'];

    $nilai = new Nilai($nis);

    switch($aksi){
        case 'tambah':
            $result = $nilai->tambah_nilai($id_mapel, $cp1, $cp2, $cp3, $cp4, $uts, $uas);
            if ($result) {
                $status = "sukses";
            } else {
                $status = "gagal";
            }
            header("location: ../guru/ubah-nilai?nis=$nis&mapel=$id_mapel&status=$status");
            break;
        case 'ubah': 
            $result = $nilai->ubah_nilai($id_mapel, $cp1, $cp1, $cp3, $cp4, $uts, $uas);
            if ($result) {
                $status = "sukses";
            } else {
                $status = "gagal";
            }
            header("location: ../guru/ubah-nilai?nis=$nis&mapel=$id_mapel&status=$status");
            break;
    }
}
?>