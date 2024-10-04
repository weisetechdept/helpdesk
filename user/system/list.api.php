<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    function DateThai($strDate)
    {
        $strYear = date("y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHout = date("H",strtotime($strDate));
        $strMinute = date("i",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear - $strHout:$strMinute";
    } 

    if($_GET['get'] == 'listDept') {

        $id = $_GET['id'];



            $user = $db->where('user_code',$id)->getOne('user');
            $group = $user['user_dept'];


            $db->join('user u','u.user_id = t.tick_owner','LEFT');
            $db->groupBy('t.tick_id');
            $list = $db->where('t.tick_dept',$group)->get('ticket t');

            foreach($list as $row){

                if($row['tick_type'] == 1){
                    $type = 'อุปกรณ์ IT / Software';
                } else {
                    $type = 'เครื่องใช้สำนักงาน / อาคารสถานที่';
                }

                $api['data'][] = array(
                    $row['tick_id'],
                    $type,
                    $row['tick_topic'],
                    $row['user_first_name'].' '.$row['user_last_name'],
                    $row['tick_status'],
                    DateThai($row['tick_datetime']),
                    base64_encode($row['tick_id'])
                );
            }
            
    }


    if($_GET['get'] == 'list') {

        if(!isset($_SESSION['hd_login'])) {
            header('Location: /404');
        } else {
    
            $code = $_SESSION['hd_code'];
            $id = $db->where('user_code',$code)->getOne('user');
    
            $list = $db->where('tick_owner',$id['user_id'])->get('ticket');
    
            $db->join('user_group g','u.user_dept = g.usrg_id','LEFT');
            $emp = $db->where('user_id',$id['user_id'])->getOne('user u');
    
            if($emp['usrg_branch'] == '1'){
                $branch = 'สำนักงานใหญ่';
            } elseif($emp['usrg_branch'] == '2') {
                $branch = 'สาขาตลาดไท';
            }
    
            $division = $emp['usrg_name'];
    
            foreach($list as $row){
                if($row['tick_type'] == 1){
                    $type = 'อุปกรณ์ IT / Software';
                } else {
                    $type = 'เครื่องใช้สำนักงาน / อาคารสถานที่';
                }
    
                $api['data'][] = array(
                    $row['tick_id'],
                    $type,
                    $row['tick_topic'],
                    $branch,
                    $division,
                    $row['tick_status'],
                    DateThai($row['tick_datetime']),
                    base64_encode($row['tick_id'])
                );
            }
        }
        
    }

    

    echo json_encode($api);