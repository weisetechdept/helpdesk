<?php 
    session_start();
    require_once '../../db-conn.php';

    $request = json_decode(file_get_contents('php://input'));
    $fname = $request->f_name;
    $lname = $request->l_name;
    $dept = $request->department;
    $uid = $request->uid;

    if($fname == '' || $lname == '' || $dept == '0') {
        $api = array(
            'status' => 'error',
            'message' => 'โปรดตรวจสอบ คุณยังไม่ได้กรอกข้อมูลชื่อ นามสกุล หรือ แผนกที่คุณสังกัด'
        );
    } elseif($uid == '') {
        $api = array(
            'status' => 'error',
            'message' => 'ไม่สามารถสมัครสมาชิกได้ กรุณาลองใหม่อีกครั้ง'
        );
    } else {
        $data = array(
            'user_first_name' => $fname,
            'user_last_name' => $lname,
            'user_uid' => $uid,
            'user_dept' => $dept,
            'user_permission' => 'officer',
            'user_status' => '0',
            'user_datetime' => date('Y-m-d H:i:s')
        );

        $db->insert('user', $data);
        if($db->count > 0) {
            $api = array(
                'status' => 'success',
                'message' => 'สมัครสมาชิกสำเร็จ'
            );
        } else {
            $api = array(
                'status' => 'error',
                'message' => 'สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
            );
        }
    }

    echo json_encode($api);