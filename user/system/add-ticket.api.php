<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if(!isset($_SESSION['hd_login'])) {
        header('Location: /404');
    } else {
        $id = $_SESSION['hd_user_id'];

        $db->join('user_group g','g.usrg_id=u.user_dept','LEFT');
        $user = $db->where('user_id',$id)->getOne('user u');

        if($user['user_dept'] == '1') {
            $branch = 'สำนักงานใหญ่';
        } elseif($user['user_dept'] == '2') {
            $branch = 'สาขาตลาดไท';
        }

        $api = array(
            'name' => $user['user_first_name'].' '.$user['user_last_name'],
            'permission' => $user['user_permission'],
            'department' => $user['usrg_name'],
            'branch' => $branch
        );

    }
        
    echo json_encode($api);