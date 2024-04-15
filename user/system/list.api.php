<?php
    require_once '../../db-conn.php';

    $list = $db->get('ticket');

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

    echo json_encode($api);