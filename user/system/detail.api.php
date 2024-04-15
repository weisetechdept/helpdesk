<?php
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';
    
    $id = $_GET['id'];
    
    $detail = $db->where('tick_id',$id)->getOne('ticket');

    $api = array(
        'tick_id' => $detail['tick_id'],
        'tick_type' => $detail['tick_type'],
        'tick_topic' => $detail['tick_topic'],
        'tick_detail' => $detail['tick_detail'],
        'tick_branch' => $detail['tick_branch'],
        'tick_division' => $detail['tick_division'],
        'tick_status' => $detail['tick_status'],
        'tick_datetime' => $detail['tick_datetime']
    );

    echo json_encode($api);

    