<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $group = $_SESSION['adminGroup'];

    function DateThai($strDate)
    {
        $strYear = date("y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    } 

    if($_GET['action'] == 'list'){
        $type = $db->where('type_group',$group)->get('fix_type');
        foreach($type as $t){
            $api['data'][] = array(
                $t['type_id'],
                $t['type_code'],
                $t['type_name'],
                $t['type_status'],
                DateThai ($t['type_datetime'])
            );
        } 
    }

    if($_GET['action'] == 'editData'){
        $request = json_decode(file_get_contents('php://input'));
        $id = $request->id;
        $data = array(
            'type_code' => $request->code,
            'type_name' => $request->name,
            'type_status' => $request->status,
            'type_update_at' => date('Y-m-d H:i:s')
        );
        $edit = $db->where('type_id',$id)->update('fix_type', $data);
        if($edit){
            $api['status'] = 'success';
            $api['message'] = 'แก้ไขข้อมูลสำเร็จ';
        }else{
            $api['status'] = 'error';
            $api['message'] = 'แก้ไขข้อมูลไม่สำเร็จ';
        }

    }

    if($_GET['action'] == 'getData'){
        $type = $db->where('type_id',$_GET['id'])->getOne('fix_type');
        $api['data'] = array(
            'id' => $type['type_id'],
            'code' => $type['type_code'],
            'name' => $type['type_name'],
            'status' => $type['type_status']
        );
        
    }

    if($_GET['action'] == 'add' && !empty($group)){
        $request = json_decode(file_get_contents('php://input'));

        $data = array(
            'type_code' => $request->code,
            'type_name' => $request->name,
            'type_group' => $group,
            'type_status' => '1',
            'type_update_at' => date('Y-m-d H:i:s'),
            'type_datetime' => date('Y-m-d H:i:s')
        );
        $add = $db->insert('fix_type', $data);
        if($add){
            $api['status'] = 'success';
            $api['message'] = 'เพิ่มข้อมูลสำเร็จ';
        }else{
            $api['status'] = 'error';
            $api['message'] = 'เพิ่มข้อมูลไม่สำเร็จ';
        }

    }

    echo json_encode($api);