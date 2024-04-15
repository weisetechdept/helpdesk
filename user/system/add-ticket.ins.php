<?php
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';
    $request = json_decode(file_get_contents('php://input'));

    $type = $request->type;
    $topic = $request->topic;
    $detail = $request->detail;
    $owner = $request->owner;
    $branch = $request->branch;
    $division = $request->division;

    $data = array(
        'tick_type' => $type,
        'tick_topic' => $topic,
        'tick_detail' => $detail,
        'tick_code' => '',
        'tick_owner' => $owner,
        'tick_branch' => $branch,
        'tick_division' => $division,
        'tick_status' => '1',
        'tick_datetime' => date('Y-m-d H:i:s')
    );
    $id = $db->insert('ticket', $data);
    if($id){
        $api = array('status' => 'success', 'id' => $id);
    } else {
        $api = array('status' => 'error');
    }
        
    echo json_encode($api);