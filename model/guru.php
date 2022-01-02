<?php

require_once dirname(__FILE__) . '/../config_sekolah.php';
require_once dirname(__FILE__) . '/../connection.php';

class Guru
{
    public function __construct($nip)
    {
        $this->nip = $nip;
    }

    public function cek_wali_kelas()
    {
        global $conn;
        $query = "SELECT * FROM kelas WHERE nip = '$this->nip'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_nama_guru()
    {
        global $conn;
        $query = "SELECT nama_guru FROM guru WHERE nip = '$this->nip'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama_guru = $row['nama_guru'];
            return $nama_guru;
        } else {
            return false;
        }
    }

    public function tambah_data_guru($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $id_kelas, $tanggal_lahir, $uas)
    {
        global $conn;
        $query = "INSERT INTO guru(nip, nama_guru, jenis_kelamin, alamat, email, no_telp, agama, status, id_kelas, tanggal_lahir, password)
        VALUES ($nip, $nama_guru, $jenis_kelamin, $alamat, $email, $no_telp, $agama, $status, $id_kelas, $tanggal_lahir, $uas)";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
