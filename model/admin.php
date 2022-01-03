<?php 

require_once dirname(__FILE__) . '/../connection.php';

class Admin {
    public function get_detail_admin_by_email($email)
    {
        global $conn;
        $query = "SELECT id_admin,nama_admin,email FROM admin WHERE email = '$email' LIMIT 1";
        $result = $conn->query($query);
        if ($result) {
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                return $admin;
            }
        } 
        return false;
    }

    public function get_detail_admin_by_id($id_admin)
    {
        global $conn;
        $query = "SELECT id_admin,nama_admin,email FROM admin WHERE id_admin = '$id_admin' LIMIT 1";
        $result = $conn->query($query);
        if ($result) {
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                return $admin;
            }
        } 
        return false;
    }

    public function cek_login_admin($email, $password)
    {
        global $conn;
        $query = "SELECT password FROM admin WHERE email = '$email' LIMIT 1";
        $result = $conn->query($query);

        if ($result) {
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                $db_password = $admin['password'];
                if ($password === $db_password) {
                    return true;
                } else {
                    return false;
                }
            }
        } 
        return false;
    }
}

?>