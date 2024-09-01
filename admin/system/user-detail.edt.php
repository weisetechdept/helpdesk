<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));

    $id = $request->id;
    
    $code = $request->code;
    $f_name = $request->f_name;
    $l_name = $request->l_name;
    $tel = $request->tel;
    $thai_id = $request->thai_id;
    $dept = $request->dept;
    $permission = $request->permission;
    $status = $request->status;

    $data = array(
        'user_code' => $code,
        'user_first_name' => $f_name,
        'user_last_name' => $l_name,
        'user_tel' => $tel,
        'user_thai_id' => $thai_id,
        'user_dept' => $dept,
        'user_permission' => $permission,
        'user_status' => $status
    );

    $update = $db->where('user_id',$id)->update('user',$data);

    if($update){
        $api['status'] = 'success';
    }else{
        $api['status'] = 'error';
    }

    echo json_encode($api);
