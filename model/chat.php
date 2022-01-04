<?php
require_once '../connection.php';

class Chat
{

    public function cek()
    {
        global $conn;
        if ($conn->connect_errno) {
            echo "Failed";
        } else {
            echo "Connect berhsil";
        }
    }

    public function get_chat_murid($nis, $nip)
    {
        global $conn;
        $hasil = $conn->query("SELECT * FROM chats WHERE murid_id = '$nis' AND guru_id = '$nip'  ORDER BY timestamps ASC");
        return $hasil;
    }

    public function get_murid_name($nis)
    {
        global $conn;
        $hasil = $conn->query("SELECT nama FROM murid WHERE nis = '$nis' LIMIT 1");
        $name = $hasil->fetch_assoc()['nama'];
        return $name;
    }

    public function get_jumlah_chat_masuk($nip)
    {
        global $conn;
        $query = "SELECT COUNT(*) As total_records FROM chats INNER JOIN siswa ON siswa.nis = chats.murid_id WHERE guru_id = $nip GROUP BY murid_id";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total_records'];
        } else {
            return 0;
        }
    }

    public function get_chat_json($id_murid, $id_wali)
    {
        $result = $this->get_chat_murid($id_murid, $id_wali);
        $data = array();
        if ($result) {
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
            $status = true;
            $message = "Mengambil chats sukses";
            $code = 200;
        } else {
            $status = false;
            $message = "Gagal mengambil chats";
            $data = [];
            $code = 404;
        }

        $response = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($response);
    }
    public function send_msg_to_siswa($nis, $nip_wali, $msg)
    {
        global $conn;
        $result = $conn->query("CALL send_message_to_siswa('$nis', '$nip_wali', '$msg')");
        while ($conn->more_results()) {
            $conn->next_result();
        }
        if ($result) {
            $status = true;
            $message = "Sukses mengirim pesan";
            $code = 200;
        } else {
            $status = false;
            $status = "Gagal mengirim pesan";
            $code = 404;
        }
        $response = array(
            'status' => $status,
            'message' => $message,
        );
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($response);
    }
    public function send_msg_to_walikelas($nis, $nip_wali, $msg)
    {
        global $conn;
        $result = $conn->query("CALL send_message_to_wali_kelas('$nis', '$nip_wali', '$msg')");
        while ($conn->more_results()) {
            $conn->next_result();
        }
        if ($result) {
            $status = true;
            $message = "Sukses mengirim pesan";
            $code = 200;
        } else {
            $status = false;
            $status = "Gagal mengirim pesan";
            $code = 404;
        }
        $response = array(
            'status' => $status,
            'message' => $message,
        );
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($response);
    }
}

$chat = new Chat();
