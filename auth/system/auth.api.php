<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");
    
    $request = json_decode(file_get_contents('php://input'));
    $userId = $request->userId;

    $user = $db->where('user_uid',$userId)->getOne('user');

    if($user == null) {
        $api = array(
            'status' => 'error',
            'message' => 'User not found'
        );
    } elseif($user['user_status'] == 1) {
        $_SESSION['hd_login'] = true;
        $_SESSION['hd_permission'] = $user['user_permission'];
        $_SESSION['hd_user_id'] = $user['user_id'];
        $api = array(
            'status' => 'success',
            'name' => $user['user_first_name'].' '.$user['user_last_name']
        );
    } elseif($user['user_status'] == 0) {
        $api = array(
            'status' => 'hold',
            'message' => 'User not verified'
        );
    }

    echo json_encode($api);
?>