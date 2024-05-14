<?php 
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));
    $branch = $request->branch;

    if($branch == '0') {
        $api[] = array(
            'id' => '0',
            'name' => 'โปรดเลือกแผนก'
        );
    } else {
        $dept = $db->where('usrg_branch',$branch)->where('usrg_status',1)->get('user_group');
        foreach($dept as $d) {

            $api[] = array(
                'id' => $d['usrg_id'],
                'name' => $d['usrg_name']
            );
        }
    }

    echo json_encode($api);