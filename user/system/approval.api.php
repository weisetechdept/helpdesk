<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';

    $request = json_decode(file_get_contents('php://input'));

    $tid = $request->id;

    $data = array(
        'tick_status' => '1'
    );
    $update = $db->where('tick_id',$tid)->update('ticket',$data);

    if($update){
        $api = array(
            'status' => 'success',
            'message' => 'Ticket Approved'
        );
    } else {
        $api = array(
            'status' => 'error',
            'message' => 'Failed to approve ticket'
        );
    }

    echo json_encode($api);