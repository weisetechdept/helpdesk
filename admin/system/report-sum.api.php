<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $group = $_SESSION['adminGroup'];

    $start = $_GET['start'].' 00:00:00';
    $end = $_GET['end'].' 23:59:59';

    $ticketAll = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_caretaker', $group)->getValue('ticket', 'COUNT(*)');

    function countByType($id){
        global $db, $start, $end, $group;
        $countDb = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->getValue('ticket', 'COUNT(*)');
        return $countDb;
    }

    $type = $db->where('type_group',$group)->orderBy('type_code',"ASC")->get('fix_type');
    
    foreach ($type as $t) {
        $api['byType']['code'][] = $t['type_code'];
        $api['byType']['name'][] = $t['type_name'];
        $api['byType']['count'][] = countByType($t['type_id']);
    }
    
    echo json_encode($api);
    