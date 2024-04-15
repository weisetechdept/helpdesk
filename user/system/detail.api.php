<?php
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';
    
    $id = $_GET['id'];
    
    $detail = $db->where('tick_id','13')->getOne('ticket');

    $api = array(
        'id' => $detail['tick_id'],
        'type' => $detail['tick_type'],
        'topic' => $detail['tick_topic'],
        'detail' => $detail['tick_detail'],
        'branch' => $detail['tick_branch'],
        'division' => $detail['tick_division'],
        'status' => $detail['tick_status'],
        'datetime' => $detail['tick_datetime']
    );

    echo json_encode($api);

    