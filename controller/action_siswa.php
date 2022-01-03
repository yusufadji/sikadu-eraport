<?php
require_once dirname(__FILE__) . '/../model/data.php';

if (isset($_POST['tambah-siswa'])) {
    $nip = $_POST['nis'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $agama = $_POST['agama'];
    $kelas = $_POST['kelas'];
    $passsiswa = $_POST['passsiswa'];
    $hashed_password = password_hash($passsiswa, PASSWORD_BCRYPT);
    $siswa = new Data();
    $result = $siswa->tambah_data_siswa($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $kelas, $tanggallahir, $hashed_password);
    var_dump($result);
    if ($result) {
        $status = "sukses";
    } else {
        $status = "gagal";
    }

    header("location: ../admin/data-siswa?status=$status");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-siswa");
}

if (isset($_POST['ubah-siswa'])) {
    $nip = $_POST['nis'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $agama = $_POST['agama'];
    $kelas = $_POST['kelas'];
    $passsiswa = $_POST['passsiswa'];
    $hashed_password = password_hash($passsiswa, PASSWORD_BCRYPT);
    $siswa = new Data();
    $result = $siswa->ubah_data_siswa($nip, $nama, $jenkel, $alamat, $email, $telepon, $agama, $kelas, $tanggallahir, $hashed_password);
    var_dump($result);
    if ($result) {
        $status = "sukses";
    } else {
        $status = "gagal";
    }
    // echo $conn->error;
    // $result = $conn->query("...");
    header("location: ../admin/data-siswa");
} else if (isset($_POST['batalkan'])) {
    header("location: ../admin/data-siswa");
}
