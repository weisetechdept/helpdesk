<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

        $id = $_SESSION['hd_user_id'];

        $list = $db->where('tick_status', array(1,2,3,4),'IN')->get('ticket');

        $db->join('user_group g','u.user_dept = g.usrg_id','LEFT');
        $emp = $db->where('user_id',$id)->getOne('user u');

        if($emp['usrg_branch'] == '1'){
            $branch = 'สำนักงานใหญ่';
        } elseif($emp['usrg_branch'] == '2') {
            $branch = 'สาขาตลาดไท';
        }
        $division = $emp['usrg_name'];


        foreach($list as $row){
            if($row['tick_type'] == 1){
                $type = 'อุปกรณ์ IT / Software';
            } else {
                $type = 'เครื่องใช้สำนักงาน / อาคารสถานที่';
            }

            $api['data'][] = array(
                $row['tick_id'],
                $type,
                $row['tick_topic'],
                $branch,
                $division,
                $row['tick_status'],
                $row['tick_datetime']
            );
        }
    

    echo json_encode($api);