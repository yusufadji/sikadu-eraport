<?php

require_once dirname(__FILE__) . '/../connection.php';

class Data
{
    public function tambah_data_guru($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "INSERT INTO guru(nip, nama_guru, jenis_kelamin, alamat, email, no_telp, agama, status, tanggal_lahir, password)
        VALUES ('$nip', '$nama_guru', '$jenis_kelamin', '$alamat', '$email', '$no_telp', '$agama', '$status', '$tanggal_lahir', '$password')";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_data_guru($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "UPDATE guru SET nip='$nip', nama_guru='$nama_guru', jenis_kelamin='$jenis_kelamin', alamat='$alamat', email='$email', no_telp='$no_telp', agama='$agama', status='$status', tanggal_lahir='$tanggal_lahir', password='$password' WHERE nip='$nip'";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function tambah_data_siswa($nis, $nama_siswa, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $kelas, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "INSERT INTO siswa(nis, nama_siswa, jenis_kelamin, alamat, email, no_telp, agama, id_kelas, tanggal_lahir, password)
        VALUES ('$nis', '$nama_siswa', '$jenis_kelamin', '$alamat', '$email', '$no_telp', '$agama', '$kelas', '$tanggal_lahir', '$password')";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_data_siswa($nis, $nama_siswa, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $kelas, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "UPDATE siswa SET nis='$nis', nama_siswa='$nama_siswa', jenis_kelamin='$jenis_kelamin', alamat='$alamat', email='$email', no_telp='$no_telp', agama='$agama', id_kelas='$kelas', tanggal_lahir='$tanggal_lahir', password='$password' WHERE nis='$nis'";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
