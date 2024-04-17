<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");
    
    $id = $_GET['id'];
    $detail = $db->where('tick_id',$id)->getOne('ticket');

    if($detail['tick_owner'] == $_SESSION['hd_user_id']){

        $db->join('user_group g','u.user_dept = g.usrg_id','LEFT');
        $emp = $db->where('user_id',$detail['tick_owner'])->getOne('user u');

        if($emp['usrg_branch'] == '1'){
            $branch = 'สำนักงานใหญ่';
        } elseif($emp['usrg_branch'] == '2') {
            $branch = 'สาขาตลาดไท';
        }
        $division = $emp['usrg_name'];
        $owner = $emp['user_first_name'].' '.$emp['user_last_name'];

        if($detail['tick_type'] == '1'){
            $type = 'อุปกรณ์ IT / Software';
        } else {
            $type = 'อาคารสถานที่ / เครื่องใช้สำนักงาน';
        }


        $api = array(
            'id' => $detail['tick_id'],
            'type' => $type,
            'topic' => $detail['tick_topic'],
            'detail' => $detail['tick_detail'],
            'code' => $detail['tick_code'],
            'owner' => $owner,
            'branch' => $branch,
            'division' => $division,
            'status' => $detail['tick_status'],
            'datetime' => $detail['tick_datetime']
        );

    } else {
        $api = array('status' => 'error', 'message' => 'Permission denied');
    }
    

    echo json_encode($api);

    