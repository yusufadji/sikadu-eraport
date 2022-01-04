<?php

require_once dirname(__FILE__) . '/../connection.php';

class Kelas
{
    public function tambah_kelas($nipwali, $namakelas)
    {
        global $conn;
        $query = "CALL tambah_kelas('$nipwali','$namakelas')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_kelas($idkelas, $nipwali, $namakelas)
    {
        global $conn;
        $query = "CALL ubah_kelas('$idkelas','$nipwali','$namakelas')";
        $result = $conn->query($query);
        $conn->next_result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_jumlah_siswa_kelas($idkelas)
    {
        global $conn;
        $query = "SELECT COUNT(*) As total_records FROM siswa WHERE id_kelas = $idkelas";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total_records'];
        } else {
            return 0;
        }
    }

    public function get_daftar_kelas($limit = 0, $offset = 0)
    {
        global $conn;
        $query_limit = $limit > 0 ? "LIMIT $limit" : "";
        $query_offset = $offset > 0 ? "OFFSET $offset" : "";
        $query = "SELECT * FROM kelas $query_limit $query_offset";
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function cek_wali_kelas($nip)
    {
        global $conn;
        $query = "SELECT * FROM kelas WHERE nip = '$nip'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }
}
