<?php

require_once dirname(__FILE__) . '/../config_sekolah.php';
require_once dirname(__FILE__) . '/../connection.php';

class Mapel
{
    public function get_daftar_mapel($limitoffset = "")
    {
        global $conn;
        if (strlen($limitoffset) > 0) {
            $query_limit = $limitoffset;
        } else {
            $query_limit = "";
        }

        $query = "SELECT id_mapel, nama_mapel, mata_pelajaran.nip, nama_guru FROM mata_pelajaran INNER JOIN guru ON mata_pelajaran.nip = guru.nip $query_limit";
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_jumlah_mapel()
    {
        global $conn;
        $query = "SELECT COUNT(*) As total_records FROM mata_pelajaran";
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function tambah_mapel($nip, $namamapel)
    {
        global $conn;
        $query = "INSERT INTO mata_pelajaran(nip, nama_mapel) VALUES ('$nip', '$namamapel')";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_mapel($idmapel, $nipwali, $namamapel)
    {
        global $conn;
        $query = "UPDATE mata_pelajaran SET nip='$nipwali', nama_mapel='$namamapel' WHERE id_mapel=$idmapel";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
