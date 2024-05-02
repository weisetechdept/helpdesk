<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $id = $_GET['id'];

    $user = $db->where('user_id',$id)->getOne('user');

    $api['user'] = array(
        'f_name' => $user['user_first_name'],
        'l_name' => $user['user_last_name'],
        'dept' => $user['user_dept'],
        'status' => $user['user_status'],
        'permission' => $user['user_permission']
    );

    $dept = $db->where('usrg_status',1)->get('user_group');
    foreach ($dept as $value) {
        $api['dept'][] = array(
            'id' => $value['usrg_id'],
            'name' => $value['usrg_name']
        );
    }
    

    echo json_encode($api);