<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if(!isset($_SESSION['hd_login'])) {
        header('Location: /404');
    } else {
        $id = $_SESSION['hd_user_id'];

        $list = $db->where('tick_owner',$id)->get('ticket');

        foreach($list as $row){
            if($row['tick_type'] == 1){
                $type = 'อุปกรณ์ IT / Software';
            } else {
                $type = 'เครื่องใช้สำนักงาน / อาคารสถานที่';
            }

            if($row['tick_branch'] == 1){
                $branch = 'สำนักงานใหญ่';
            } else {
                $branch = 'สาขา';
            }

            if($row['tick_division'] == '1'){
                $division = 'ฝ่ายขาย';
            } elseif($row['tick_division'] == '2') {
                $division = 'ฝ่ายการตลาด';
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
    }

    echo json_encode($api);