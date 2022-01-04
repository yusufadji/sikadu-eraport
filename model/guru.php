<?php

require_once dirname(__FILE__) . '/../config_sekolah.php';
require_once dirname(__FILE__) . '/../connection.php';

class Guru
{
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

    public function get_detail_guru($nip)
    {
        global $conn;
        $query = "SELECT * FROM guru WHERE nip = '$nip'";
        $result = $conn->query($query);
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }

    public function get_nama_guru($nip)
    {

        $guru = $this->get_detail_guru($nip);
        if ($guru) {
            return $guru['nama_guru'];
        } else {
            return false;
        }
    }

    public function cek_login_guru($nip, $password)
    {
        $guru = $this->get_detail_guru($nip);
        if (!$guru) {
            return false;
        }
        $db_password = $guru['password'];
        $verify = password_verify($password, $db_password);
        if ($verify) {
            return true;
        } else {
            return false;
        }
    }

    public function get_mapel_by_guru($nip)
    {
        global $conn;
        $query = "SELECT * FROM mata_pelajaran WHERE nip = '$nip'";
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
