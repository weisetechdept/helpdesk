<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $group = $_SESSION['adminGroup'];

    $start = $_GET['start'].' 00:00:00';
    $end = $_GET['end'].' 23:59:59';

    $ticketAll = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_caretaker', $group)->getValue('ticket', 'COUNT(*)');

    function countByTypeAll($id){
        global $db, $start, $end, $group;
        $countDb = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->where('tick_status',array("1","2","3"),"IN")->getValue('ticket', 'COUNT(*)');
        return $countDb;
    }

    function countByTypeDone($id){
        global $db, $start, $end, $group;
        $countDb = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->where('tick_status',3)->getValue('ticket', 'COUNT(*)');
        return $countDb;
    }

    function countByTypeWait($id){
        global $db, $start, $end, $group;
        $countDb = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->where('tick_status',1)->getValue('ticket', 'COUNT(*)');
        return $countDb;
    }

    function countByTypeProcess($id){
        global $db, $start, $end, $group;
        $countDb = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->where('tick_status',2)->getValue('ticket', 'COUNT(*)');
        return $countDb;
    }

    function avgTime($id){
        global $db, $start, $end, $group;

        //$ticked = $db->where('tick_datetime',array($start,$end),"BETWEEN")->where('tick_fix_type',$id)->where('tick_caretaker', $group)->where('tick_status',3)->get('ticket');
        $ticked = $db->where('tick_id',89)->get('ticket');
        $keepTime = 0;
        foreach ($ticked as $t) {
            $date1=date_create($t['tick_datetime']);
            $date2=date_create($t['tick_finished']);
            $diff=date_diff($date1,$date2);
            $timeDiff = ($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s;
            $keepTime += $timeDiff;
        }

        if (count($ticked) > 0) {
            $averageTime = $keepTime / count($ticked);
            $days = floor($averageTime / 86400);
            $hours = floor(($averageTime % 86400) / 3600);
            $minutes = floor(($averageTime % 3600) / 60);
            return "$days:$hours:$minutes";
        } else {
            return "ไม่มีข้อมูล";
        }
    }

    $type = $db->where('type_group',$group)->orderBy('type_code',"ASC")->get('fix_type');
    
    foreach ($type as $t) {
        $api['byType']['code'][] = $t['type_code'];
        $api['byType']['name'][] = $t['type_name'];
        $api['byType']['count'][] = countByTypeAll($t['type_id']);
        $api['byType']['done'][] = countByTypeDone($t['type_id']);
        $api['byType']['wait'][] = countByTypeWait($t['type_id']);
        $api['byType']['process'][] = countByTypeProcess($t['type_id']);
        $api['byType']['avgTime'][] = avgTime($t['type_id']);
    }

    $api['byType']['code'][] = 'ไม่ระบุ';
    $api['byType']['name'][] = 'ยังไม่ระบุประเภท';
    $api['byType']['count'][] = countByTypeAll(0);
    $api['byType']['done'][] = countByTypeDone(0);
    $api['byType']['wait'][] = countByTypeWait(0);
    $api['byType']['process'][] = countByTypeProcess(0);
    $api['byType']['avgTime'][] = avgTime(0);
   
    echo json_encode($api);
    