<?php 

require_once dirname(__FILE__) . '/../config_sekolah.php';
require_once dirname(__FILE__) .'/../connection.php';

class Nilai {
    private $nis_siswa;
    private $nip_walikelas;
    private $id_raport;

    public function __construct($nis_siswa) {
        $this->nis_siswa = $nis_siswa;
    }
    private function set_wali_kelas()
    {
        global $conn;
        $query = "SELECT kelas.nip FROM siswa INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE nis = '$this->nis_siswa'";
        $result = $conn->query($query);
        $result = $result->fetch_assoc();
        $this->nip_walikelas = $result['nip'];
    }

    private function cek_raport(){
        global $conn;
        $query = "SELECT * FROM raport WHERE nis = '$this->nis_siswa' AND tahun_ajaran = ".CURRENT_TAHUN_AJARAN." AND rapor_semester = ".CURRENT_SEMESTER."";
        $result = $conn->query($query);
        echo $conn->error;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "ada raport";
            echo $row['id_raport'];
            $this->id_raport = $row['id_raport'];
            return true;
        } else {
            return false;
        }
    }
    private function buat_raport()
    {
        global $conn;
        $this->set_wali_kelas();
        $query = "INSERT INTO raport (tanggal, nis, nip, tahun_ajaran, rapor_semester) VALUES (CURRENT_DATE(), '$this->nis_siswa', '$this->nip_walikelas', ".CURRENT_TAHUN_AJARAN.", ".CURRENT_SEMESTER.")";
        $result = $conn->query($query);
        if ($result) {
            $this->id_raport = $conn->insert_id;
            echo $this->id_raport;
        }
    }
    public function tambah_nilai($id_mapel, $cp1=0, $cp2=0, $cp3=0, $cp4=0, $uts=0, $uas=0)
    {
        global $conn;
        if (!$this->cek_raport()) {
            echo "belum ada raport";
            $this->buat_raport();
        } 
        $smt = CURRENT_SEMESTER;
        $query = "INSERT  INTO nilai(nis, id_mapel, id_raport, semester, cp1, cp2, cp3, cp4, uts, uas) VALUES ('$this->nis_siswa', $id_mapel, $this->id_raport, $smt, $cp1, $cp2, $cp3, $cp4, $uts, $uas)";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function ubah_nilai($id_mapel, $cp1, $cp2, $cp3, $cp4, $uts, $uas)
    {
        global $conn;
        if (!$this->cek_raport()) {
            echo "belum ada raport";
            return false;
        }
        $query = "UPDATE nilai SET cp1 = $cp1, cp2 = $cp2, cp3 = $cp3, cp4 = $cp4, uts = $uts, uas = $uas WHERE nis = '$this->nis_siswa' AND id_mapel = $id_mapel AND semester = ".CURRENT_SEMESTER."";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_nilai($id_mapel)
    {
        global $conn;
        $query = "SELECT * FROM siswa,nilai WHERE nilai.nis = '$this->nis_siswa' AND nilai.id_mapel = $id_mapel AND semester = " . CURRENT_SEMESTER;
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}


?>