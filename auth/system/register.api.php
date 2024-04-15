<?php 
    session_start();
    require_once '../../db-conn.php';

    $request = json_decode(file_get_contents('php://input'));
    $branch = $request->branch;

    
        $dept = $db->where('usrg_branch',$branch)->where('usrg_status',1)->get('user_group');
        foreach($dept as $d) {
            $api[] = array(
                'id' => $d['usrg_id'],
                'name' => $d['usrg_name']
            );
        }
    

    echo json_encode($api);