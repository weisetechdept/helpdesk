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

    function branch($id) {
        if($id == '1'){
            return 'สำนักงานใหญ่';
        }elseif($id == '2') {
            return 'ตลาดไท';
        }
    }

    if($_GET['action'] == 'search'){
        $start = $_GET['start'].' 00:00:00';
        $end = $_GET['end'].' 23:59:59';

        $db->join('user_group ug','ug.usrg_id = t.tick_dept','LEFT');
        $db->join('fix_type f','f.type_id = t.tick_fix_type','LEFT');
        $db->join('vendor v','v.vend_id = t.tick_vendor','LEFT');
        $db->join('user u','u.user_id = t.tick_owner','LEFT');

        $search = $db->where('tick_datetime',Array($start,$end),'BETWEEN')->where('tick_status',array('1','2','3','4'),"IN")->where('tick_caretaker',$group)->get('ticket t');
        if($search) {
            foreach ($search as $value) {
            
                if($value['vend_name'] == '') {
                    $vend_name = 'ไม่ระบุ';
                } else {
                    $vend_name = $value['vend_name'];
                }
    
                if($value['type_name'] == '') {
                    $tn = 'ไม่ระบุ';
                }else {
                    $tn = $value['type_name'];
                }
    
                if($value['tick_type'] == '1'){
                    $tp = 'อุปกรณ์ IT / Software';
                } elseif ($value['tick_type'] == '2') {
                    $tp = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน';
                } elseif ($value['tick_type'] == '3') {
                    $tp = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
                } elseif ($value['tick_type'] == '4') {
                    $tp = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
                }
    
                if($value['tick_code'] == '') {
                    $tick_code = 'ไม่ระบุ';
                } else {
                    $tick_code = $value['tick_code'];
                }
    
                $api['data'][] = array(
                    $value['tick_id'],
                    $tick_code,
                    $value['tick_topic'],
                    $tp,
                    $tn,
                    $value['user_first_name'].' '.$value['user_last_name'],
                    branch($value['usrg_branch']),
                    $value['usrg_name'],
                    $vend_name,
                    $value['tick_status'],
                    DateThai($value['tick_datetime'])
                );
    
            }
        } else {
            $api['data'] = array();
        }
        
    }

    if($_GET['action'] == 'detail') {

        if($value['vend_name'] == '') {
            $vend_name = 'ไม่ระบุ';
        } else {
            $vend_name = $value['vend_name'];
        }

        $db->join('user_group ug','ug.usrg_id = t.tick_dept','LEFT');
        $db->join('fix_type f','f.type_id = t.tick_fix_type','LEFT');
        $db->join('vendor v','v.vend_id = t.tick_vendor','LEFT');
        $db->join('user u','u.user_id = t.tick_owner','LEFT');
        $ticket = $db->where('tick_status',array('1','2','3','4'),"IN")->where('tick_caretaker',$group)->get('ticket t');
        if($ticket) {
            foreach ($ticket as $key => $value) {

                if($value['tick_code'] == '') {
                    $tick_code = 'ไม่ระบุ';
                } else {
                    $tick_code = $value['tick_code'];
                }

                if($value['type_name'] == '') {
                    $tn = 'ไม่ระบุ';
                }else {
                    $tn = $value['type_name'];
                }

                if($value['tick_type'] == '1'){
                    $tp = 'อุปกรณ์ IT / Software';
                } elseif ($value['tick_type'] == '2') {
                    $tp = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน';
                } elseif ($value['tick_type'] == '3') {
                    $tp = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
                } elseif ($value['tick_type'] == '4') {
                    $tp = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
                }
                
                $api['data'][] = array(
                    $value['tick_id'],
                    $tick_code,
                    $value['tick_topic'],
                    $tp,
                    $tn,
                    $value['user_first_name'].' '.$value['user_last_name'],
                    branch($value['usrg_branch']),
                    $value['usrg_name'],
                    $vend_name,
                    $value['tick_status'],
                    DateThai($value['tick_datetime'])
                );
            }
        } else {
            $api['data'] = array();
        }

    }

    echo json_encode($api);