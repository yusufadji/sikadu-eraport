<?php

require_once dirname(__FILE__) . '/../connection.php';

class Data
{
    public function tambah_data_guru($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "CALL tambah_data_guru('$nip','$nama_guru','$jenis_kelamin','$alamat','$email','$no_telp','$agama','$status','$tanggal_lahir','$password')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_data_guru($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "CALL ubah_data_guru('$nip','$nama_guru','$jenis_kelamin','$alamat','$email','$no_telp','$agama','$status','$tanggal_lahir','$password')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function tambah_data_siswa($nis, $nama_siswa, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $kelas, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "CALL tambah_data_siswa('$nis', '$nama_siswa', '$jenis_kelamin', '$alamat', '$email', '$no_telp', '$agama', '$kelas', '$tanggal_lahir', '$password')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_data_siswa($nis, $nama_siswa, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $kelas, $tanggal_lahir, $password)
    {
        global $conn;
        $query = "CALL ubah_data_siswa('$nis', '$nama_siswa', '$jenis_kelamin', '$alamat', '$email', '$no_telp', '$agama', '$kelas', '$tanggal_lahir', '$password')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
