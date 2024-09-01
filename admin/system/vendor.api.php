<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    function DateThai($strDate)
    {
        $strYear = date("y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    } 

    $group = $_SESSION['adminGroup'];

    $requset = json_decode(file_get_contents('php://input'));
    $action = $requset->action;

    if($action == 'detail'){
        $dept = $requset->dept;
        $detail = $db->where('usrg_id',$dept)->getOne('user_group');

        $api['detail'] = array(
            'id' => $detail['usrg_id'],
            'name' => $detail['usrg_name'],
            'branch' => $detail['usrg_branch']
        );

    }

    if($_GET['action'] == 'detail') {
        $dept = $_GET['dept'];

        $db->join('vendor v','v.vend_id = t.tick_vendor','LEFT');
        $db->join('user u','u.user_id = t.tick_owner','LEFT');
        $ticket = $db->where('tick_dept',$dept)->get('ticket t');
        if($ticket) {
            foreach ($ticket as $key => $value) {
                $api['data'][] = array(
                    $value['tick_id'],
                    $value['tick_topic'],
                    $value['user_first_name'].' '.$value['user_last_name'],
                    $value['vend_name'],
                    $value['tick_status'],
                    DateThai($value['tick_datetime'])
                );
            }
        } else {
            $api['data'] = array();
        }

    }

    if($_GET['action'] == 'list' && !empty($group)) {
        
        $dept = $db->where('vend_group',$group)->where('vend_status',1)->get('vendor');

        foreach ($dept as $value) {
            $api['data'][] = array(
                $value['vend_id'],
                $value['vend_name'],
                $value['vend_group'],
                $value['vend_status'],
                DateThai($value['vend_datetime'])
            );
        }
    } else {
        $api['data'] = array();
    }

    if($action == 'add'){
        $name = $requset->name;

        if($name == '') {

            $api['status'] = 'error';
            $api['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
            echo json_encode($api);
            exit;

        } elseif (empty($group)) {
            $api = array(
                'status' => 'auth',
                'message' => 'กรุณาเข้าสู่ระบบ'
            );
        } else {

            $data = array(
                'vend_name' => $name,
                'vend_group' => $group,
                'vend_status' => '1',
                'vend_datetime' => date('Y-m-d H:i:s')
            );
            $ins = $db->insert('vendor', $data);
            if($ins) {
                $api['status'] = 'success';
                $api['message'] = 'เพิ่มข้อมูลสำเร็จ';
            } else {
                $api['status'] = 'error';
                $api['message'] = $db->getLastError();
            }

        }

    }



    echo json_encode($api);