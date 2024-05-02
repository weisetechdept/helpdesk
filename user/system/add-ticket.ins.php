<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';
    
    $request = json_decode(file_get_contents('php://input'));

    $type = $request->type;
    $topic = $request->topic;
    $detail = $request->detail;
    $code = $request->code;
    $owner = $request->owner;

    if($_SESSION['hd_user_id'] == $owner){

        $data = array(
            'tick_type' => $type,
            'tick_topic' => $topic,
            'tick_detail' => $detail,
            'tick_code' => strtoupper($code),
            'tick_owner' => $owner,
            'tick_fix_type' => '0',
            'tick_vendor' => '0',
            'tick_status' => '0',
            'tick_datetime' => date('Y-m-d H:i:s')
        );
        $id = $db->insert('ticket', $data);
        if($id){
            $api = array('status' => 'success', 'id' => $id);
        } else {
            $api = array('status' => 'error');
        }

    } else {
        $api = array('status' => 'error', 'message' => 'Permission denied');
    }
        
    echo json_encode($api);