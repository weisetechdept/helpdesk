<?php
    require_once '../../db-conn.php';
    $request = json_decode(file_get_contents('php://input'));

    $type = $request->type;
    $topic = $request->topic;
    $detail = $request->detail;

    $data = array(
        'tick_type' => $type,
        'tick_topic' => $topic,
        'tick_detail' => $detail,
        'tick_datetime' => date('Y-m-d H:i:s')
    );
    $id = $db->insert('ticket', $data);
    if($id){
        $api = array('status' => 'success', 'id' => $id);
    } else {
        $api = array('status' => 'error');
    }
        
    echo json_encode($api);