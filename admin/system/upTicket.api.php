<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if($_GET['po'] == 'stp1'){
        $request = json_decode(file_get_contents('php://input'));
        $fix = $request->type_fix;
        $vendor = $request->vendor;
        $id = $request->id;

        $data = array(
            'tick_fix_type' => $fix,
            'tick_vendor' => $vendor,
            'tick_status' => '2',
        );

        $db->where('tick_id', $id)->update('ticket', $data);

        if($db->count > 0){
            $api['status'] = 'success';
        } else {
            $api['status'] = 'error';
        }
    }

    if($_GET['po'] == 'stp2'){

        $request = json_decode(file_get_contents('php://input'));
        $id = $request->id;
        $status = $request->status;

        $data = array(
            'tick_status' => $status,
        );

        $db->where('tick_id', $id)->update('ticket', $data);

        if($db->count > 0){
            $api['status'] = 'success';
        } else {
            $api['status'] = 'error';
        }
    }

    echo json_encode($api);