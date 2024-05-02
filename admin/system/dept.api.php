<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $dept = $db->get('user_group');
    foreach ($dept as $value) {
        $api['data'][] = array(
            $value['usrg_id'],
            $value['usrg_name'],
            $value['usrg_branch'],
            $value['usrg_status']
        );
    }

    echo json_encode($api);