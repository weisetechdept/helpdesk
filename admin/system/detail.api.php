<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");
    
    $id = $_GET['id'];
    $detail = $db->where('tick_id',$id)->getOne('ticket');

        $db->join('user_group g','u.user_dept = g.usrg_id','RIGHT');
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

        $vendor = $db->where('vend_id',$detail['tick_vendor'])->getOne('vendor');
        $fix_cat = $db->where('type_id',$detail['tick_fix_type'])->getOne('fix_type');

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
            'datetime' => $detail['tick_datetime'],
            'fix_type' => $fix_cat ['type_name'],
            'vd' => $vendor['vend_name'],
        );

        $api['type_fix'][] = array(
            'id' => '0',
            'name' => '= เลือกประเภทการซ่อม ='
        );

        $type_fix = $db->where('type_status',1)->get('fix_type');
        foreach ($type_fix as $value) {
            $api['type_fix'][] = array(
                'id' => $value['type_id'],
                'name' => $value['type_name']
            );
        }


        $api['vendor'][] = array(
            'id' => '0',
            'name' => '= เลือกผู้รับเรื่อง ='
        );
        $vendor = $db->where('vend_status',1)->get('vendor');
        foreach ($vendor as $value) {
            $api['vendor'][] = array(
                'id' => $value['vend_id'],
                'name' => $value['vend_name']
            );
        }
    

    echo json_encode($api);

    