<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

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
        $ticket = $db->where('tick_dept',$dept)->where('tick_caretaker',$group)->get('ticket t');
        if($ticket) {
            foreach ($ticket as $key => $value) {
                $api['data'][] = array(
                    $value['tick_id'],
                    $value['tick_topic'],
                    $value['user_first_name'].' '.$value['user_last_name'],
                    $value['vend_name'],
                    $value['tick_status'],
                    $value['tick_datetime']
                );
            }
        } else {
            $api['data'] = array();
        }

    }

    if($_GET['action'] == 'list') {

        if($_GET['branch']== 'all'){
            $branch_list = array('1','2');
        } elseif($_GET['branch']== '1'){ 
            $branch_list = array('1');
        } elseif($_GET['branch']== '2'){ 
            $branch_list = array('2');
        }
        
        $dept = $db->where('usrg_branch',$branch_list,"IN")->get('user_group');

        foreach ($dept as $value) {
            $api['data'][] = array(
                $value['usrg_id'],
                $value['usrg_name'],
                $value['usrg_branch'],
                $value['usrg_status']
            );
        }
    }

    if($action == 'get'){
        $deptId = $requset->deptId;
        $dept = $db->where('usrg_id',$deptId)->getOne('user_group');
        $api['data'] = array(
            'id' => $dept['usrg_id'],
            'name' => $dept['usrg_name'],
            'branch' => $dept['usrg_branch'],
            'status' => $dept['usrg_status'],
            'email' => $dept['usrg_email'],
        );
    }

    if($action == 'update'){
        $id = $requset->id;
        $name = $requset->name;
        $branch = $requset->branch;
        $status = $requset->status;
        $email = $requset->email;

        if($name == '' || $branch == '0' || $status == '' || $email == '') {

            $api['status'] = 'error';
            $api['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
            exit;
        } else {

            $data = array(
                'usrg_name' => $name,
                'usrg_branch' => $branch,
                'usrg_email' => $email,
                'usrg_status' => $status,
            );

            $upd = $db->where('usrg_id',$id)->update('user_group', $data);
            if($upd) {
                $api = array(
                    'status' => 'success',
                    'message' => 'แก้ไขข้อมูลสำเร็จ'
                );
            } else {
                $api = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถแก้ไขข้อมูลได้'
                );
            }

        }
        
    }

    if($action == 'add'){
        $branch = $requset->branch;
        $name = $requset->name;
        $email = $requset->email;

        if($name == '' || $branch == '') {

            $api['status'] = 'error';
            $api['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
            echo json_encode($api);
            exit;

        } else {

            $data = array(
                'usrg_name' => $name,
                'usrg_branch' => $branch,
                'usrg_email' => $email,
                'usrg_status' => '1',
                'usrg_datetime' => date('Y-m-d H:i:s')
            );
            $ins = $db->insert('user_group', $data);
            if($ins) {
                $api['status'] = 'success';
                $api['message'] = 'เพิ่มข้อมูลสำเร็จ';
            } else {
                $api['status'] = 'error';
                $api['message'] = 'ไม่สามารถเพิ่มข้อมูลได้';
            }

        }

    }



    echo json_encode($api);