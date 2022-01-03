<?php 

require_once '../connection.php';

class Admin {
    public function cek_admin($email)
    {
        global $conn;
        $query = "SELECT * FROM admin WHERE email = '$email' LIMIT 1";
        $result = $conn->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}

?>