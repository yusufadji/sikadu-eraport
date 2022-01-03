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

    }
    public function get_nama_siswa($nis)
    {
        global $conn;
        $query = "SELECT nama_siswa FROM siswa WHERE nis = '$nis'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama_siswa = $row['nama_siswa'];
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