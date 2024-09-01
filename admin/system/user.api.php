<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if($_GET['data'] == 'addUser') {
        $request = json_decode(file_get_contents('php://input'));
        $action = $request->action;
        $code = $request->code;
        $f_name = $request->f_name;
        $l_name = $request->l_name;
        $permission = $request->permission;
        $dept = $request->dept;

        if($action == 'add' && $code != '' && $f_name != '' && $l_name != '' && $permission != '' && $dept != ''){

            $data = array(
                'user_code' => $code,
                'user_first_name' => $f_name,
                'user_last_name' => $l_name,
                'user_tel' => '',
                'user_thai_id' => '',
                'user_uid' => '',
                'user_dept' => $dept,
                'user_permission' => $permission,
                'user_img' => '',
                'user_status' => 1,
                'user_update_at' => date('Y-m-d H:i:s'),
                'user_datetime' => date('Y-m-d H:i:s')
            );

            $add = $db->insert('user',$data);

            if($add){
                $api['status'] = 'success';
            } else {
                $api['status'] = 'error';
            }

        }

    }

    if($_GET['data'] == 'dept') {
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
    }

    if($_GET['data'] == 'count'){

        $all = $db->where('user_status',array(0,1,10),"IN")->getValue('user','count(*)');
        $pending = $db->where('user_status',0)->getValue('user','count(*)');
        $active = $db->where('user_status',1)->getValue('user','count(*)');
        $inactive = $db->where('user_status',10)->getValue('user','count(*)');

        $api['count'] = array(
            'all' => $all,
            'pending' => $pending,
            'active' => $active,
            'inactive' => $inactive
        );

        $api['dept'][] = array('id' => 0,'name' => 'ทุกแผนก');

        $dept = $db->get('user_group');
        foreach($dept as $row){
            $api['dept'][] = array('id' => $row['usrg_id'],'name' => $row['usrg_name']);
        }

    }

    if($_GET['data'] == 'search'){

        $dept = $_GET['dept'];

        $db->join("user_group g", "u.user_dept = g.usrg_id", "LEFT");
        $user = $db->where('user_dept',2)->get('user u');

        if($db->count > 0){

            foreach($user as $row){
                $api['data'][] = array(
                    $row['user_id'],
                    $row['user_first_name'].' '.$row['user_last_name'],
                    $row['usrg_name'],
                    $row['user_permission'],
                    $row['user_status'],
                    $row['user_datetime']
                );
            }

        } else {

            $api['data'] = null;

        }

    }

    if($_GET['data'] == 'list'){

        if($_GET['get'] == 'all'){
            $sta = array(0,1,10);
        } elseif($_GET['get'] == 'pending'){
            $sta = array(0);
        } elseif($_GET['get'] == 'active'){
            $sta = array(1);
        } elseif($_GET['get'] == 'inactive'){
            $sta = array(10);
        }
    
        $db->join("user_group g", "u.user_dept = g.usrg_id", "LEFT");
        $user = $db->where('user_status',$sta,"IN")->get('user u');

        if($db->count > 0){
            foreach($user as $row){
                $api['data'][] = array(
                    $row['user_id'],
                    $row['user_first_name'].' '.$row['user_last_name'],
                    '[สำนักงานใหญ่] - '.$row['usrg_name'],
                    $row['user_permission'],
                    $row['user_status'],
                    $row['user_datetime']
                );
            }
    
        } else {
            $api['data'] = null;
        }

        
    }

    

    echo json_encode($api);