<?php
    session_start();
    require_once '../../db-conn.php';
    
    $request = json_decode(file_get_contents('php://input'));
    $userId = $request->userId;

    $user = $db->where('user_uid',$userId)->getOne('user');

    if($user) {
        $_SESSION['hd_login'] = true;
        $_SESSION['hd_permission'] = $user['user_permission'];
        $api = array(
            'status' => 'success'
        );
    } else {
        $api = array(
            'status' => 'error',
            'message' => 'User not found'
        );
    }

    echo json_encode($api);
?>