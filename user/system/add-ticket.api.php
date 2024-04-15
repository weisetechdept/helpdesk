<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if(!isset($_SESSION['hd_login'])) {
        header('Location: /404');
    } else {
        $id = $_SESSION['hd_user_id'];

        $user = $db->where('user_id',$id)->getOne('user');
        $api = array(
            'name' => $user['user_first_name'].' '.$user['user_last_name'],
            'permission' => $user['user_permission']
        );

    }
        
    echo json_encode($api);