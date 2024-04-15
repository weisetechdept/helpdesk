<?php 
    require_once '../../db-conn.php';

    $dept = $db->where('usrg_status',1)->get('user_group');

    foreach($dept as $d) {
        $api[] = array(
            'id' => $d['usrg_id'],
            'name' => $d['usrg_name']
        );
    }

    echo json_encode($api);