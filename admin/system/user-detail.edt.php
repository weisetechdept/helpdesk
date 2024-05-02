<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));

    $id = $request->id;
    $dept = $request->dept;
    $status = $request->status;
    $permission = $request->permission;

    $f_name = $request->f_name;
    $l_name = $request->l_name;

    $data = array(
        'user_first_name' => $f_name,
        'user_last_name' => $l_name,
        'user_dept' => $dept,
        'user_status' => $status,
        'user_permission' => $permission
    );

    $update = $db->where('user_id',$id)->update('user',$data);

    if($update){
        $api['status'] = 'success';
    }else{
        $api['status'] = 'error';
    }

    echo json_encode($api);
