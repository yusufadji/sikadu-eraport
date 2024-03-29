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
        $query = "CALL tambah_mapel('$nip','$namamapel')";
        $result = $conn->query($query);
        while ($conn->more_results()) {
            $conn->next_result();
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_mapel($idmapel, $nipwali, $namamapel)
    {
        global $conn;
        $query = "CALL ubah_mapel('$idmapel', '$nipwali', '$namamapel')";
        $result = $conn->query($query);
        while ($conn->more_results()) {
            $conn->next_result();
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
