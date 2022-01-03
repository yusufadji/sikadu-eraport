<?php 

require_once "../model/chat.php";

if (isset($_POST['action'])) {
    $nis = $_POST['id_siswa'];
    switch ($_POST['action']) {
        case 'get_chat':
            $chat->get_chat_json($_POST['id_siswa'], $_POST['id_wali']);
            break;
        case 'send_msg_to_siswa':
            $chat->send_msg_to_siswa($_POST['id_siswa'], $_POST['id_wali'], $_POST['message']);
            break;
        case 'send_msg_to_wali_kelas': 
            $chat->send_msg_to_walikelas($_POST['id_siswa'], $_POST['id_wali'], $_POST['message']);
            break;
        default:
            
            break;
    }
}

?>

