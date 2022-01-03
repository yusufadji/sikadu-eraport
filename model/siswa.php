<?php 

require_once dirname(__FILE__) . '/../config_sekolah.php';
require_once dirname(__FILE__) .'/../connection.php';

class Siswa {
    public function get_detail_siswa($nis)
    {
        global $conn;
        $query = "SELECT * FROM siswa WHERE nis = '$nis'";
        $result = $conn->query($query);
        if ($result) {
            if ($result->num_rows === 1) {
                $siswa = $result->fetch_assoc();
                return $siswa;
            }
        } 
        return false;

    }

    public function cek_login_siswa($nis, $password)
    {
        $siswa = $this->get_detail_siswa($nis);
        if (!$siswa) {
            return false;
        }
        $db_password = $siswa['password'];
        $verify = password_verify($password, $db_password);
        if ($verify) {
            return true;
        } else {
            return false;
        }
    }

    public function get_nama_siswa($nis)
    {
        $result = $this->get_detail_siswa($nis);
        if ($result) {
            $nama_siswa = $result['nama_siswa'];
            return $nama_siswa;
        } else {
            return false;
        }
    }

    public function get_wali_kelas($nis)
    {
        global $conn;
        $query = "SELECT guru.nip, guru.nama_guru, guru.jenis_kelamin FROM siswa INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        INNER JOIN guru ON kelas.nip = guru.nip WHERE nis = '$nis'";
        echo $conn->error;
        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }
}
?>