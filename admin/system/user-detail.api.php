<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

        $id = $_GET['id'];

        $user = $db->where('user_id',$id)->getOne('user');

        $api['user'] = array(
            'f_name' => $user['user_first_name'],
            'l_name' => $user['user_last_name'],
            'dept' => $user['user_dept'],
            'status' => $user['user_status'],
            'permission' => $user['user_permission'],
            'tel' => $user['user_tel'],
            'thai_id' => $user['user_thai_id'],
            'code' => $user['user_code']
        );

        $dept = $db->where('usrg_status',1)->get('user_group');
        foreach ($dept as $value) {
            if($value['usrg_branch'] == 1){
                $branch = 'สำนักงานใหญ่';
            } elseif($value['usrg_branch'] == 2){
                $branch = 'สาขาตลาดไท';
            }
            $api['dept'][] = array(
                'id' => $value['usrg_id'],
                'name' => '['.$branch.'] - '.$value['usrg_name']
            );
        }

    echo json_encode($api);