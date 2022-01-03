<?php

require_once dirname(__FILE__) . '/../connection.php';

class Kelas
{
    public function tambah_kelas($nipwali, $namakelas)
    {
        global $conn;
        $query = "INSERT INTO kelas(nip, nama_kelas) VALUES ('$nipwali', '$namakelas')";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function ubah_kelas($idkelas, $nipwali, $namakelas)
    {
        global $conn;
        $query = "UPDATE kelas SET nip='$nipwali', nama_kelas='$namakelas' WHERE id_kelas=$idkelas";
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
