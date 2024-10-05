<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $group = $_SESSION['adminGroup'];

    if(!empty($group)){

        if($_GET['get'] == 'count'){
            $all = $db->where('tick_status',array('1','2','3','4'),"IN")->where('tick_caretaker',$group)->getValue ("ticket", "count(*)");
            $wait = $db->where('tick_status',1)->where('tick_caretaker',$group)->getValue("ticket", "count(*)");
            $process = $db->where('tick_status',2)->where('tick_caretaker',$group)->getValue("ticket", "count(*)");
    
            $api['count'] = array(
                'all' => $all,
                'wait' => $wait,
                'process' => $process
            );
    
            echo json_encode($api);
        }
    
        if($_GET['list'] == 'data'){
    
            function DateThai($strDate)
            {
                $strYear = date("y",strtotime($strDate));
                $strMonth= date("n",strtotime($strDate));
                $strDay= date("j",strtotime($strDate));
            
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear";
            } 
    
            function getBranch($id){
                global $db;
                $dept = $db->where('usrg_id',$id)->getOne('user_group');
                if($dept['usrg_branch'] == '1'){
                    return 'สำนักงานใหญ่';
                } elseif($dept['usrg_branch'] == '2') {
                    return 'สาขาตลาดไท';
                }
            }
    
            function getDept($id){
                global $db;
                $dept = $db->where('usrg_id',$id)->getOne('user_group');
                return $dept['usrg_name'];
            }
    
            function getTyped($id){
                global $db;
                $type = $db->where('type_id',$id)->getOne('fix_type');
                if(!isset($type)){
                    return 'ไม่พบข้อมูล';
                } else {
                    return $type['type_code'].' - '.$type['type_name'];
                }
                
            }
            
            $sql_details_1 = ['user'=> $usern,'pass'=> $passn,'db'=> $dbn,'host'=> $hostn,'charset'=>'utf8'];
            require 'ssp.class.php';
    
            $table = 'ticket';
            $primaryKey = 'tick_id';
            $columns = [
                ['db' => 'tick_id', 'dt' => 0, 'field' => 'tick_id'],
                ['db' => 'tick_topic', 'dt' => 1, 'field'=> 'tick_topic'],
                ['db' => 'tick_fix_type', 'dt' => 2, 'field' => 'tick_fix_type',
                    'formatter' => function($d, $row){
                        return getTyped($d);
                    }
                ],
                ['db' => 'tick_dept', 'dt' => 3, 'field'=> 'tick_dept',
                    'formatter' => function($d, $row){
                        return getBranch($d);
                    }
                ],
                ['db' => 'tick_dept', 'dt' => 4, 'field'=> 'tick_dept',
                    'formatter' => function($d, $row){
                        return getDept($d);
                    }
                ],
                ['db' => 'tick_status', 'dt' => 5, 'field'=> 'tick_status',
                    'formatter' => function($d, $row){
                        if($d == 0){
                            return '<span class="badge badge-primary">รออนุมัติ (ผจก.)</span>';
                        } elseif($d == 1){
                            return '<span class="badge badge-warning">รอดำเนินการ</span>';
                        } elseif($d == 2) {
                            return '<span class="badge badge-info">กำลังดำเนินการ</span>';
                        } elseif($d == 3) {
                            return '<span class="badge badge-success">เสร็จสิ้น</span>';
                        } elseif($d == 10) {
                            return '<span class="badge badge-danger">ยกเลิก</span>';
                        }
                    }
                ],
                ['db' => 'tick_datetime', 'dt' => 6, 'field'=> 'tick_datetime',
                    'formatter' => function($d, $row){
                        return DateThai($d);
                    }
                ],
                ['db' => 'tick_id', 'dt' => 7, 'field'=> 'tick_id',
                    'formatter' => function($d, $row){
                        return '<a href="/admin/de/'.$d.'" class="btn btn-sm btn-outline-primary">ดูรายละเอียด</a>';
                    }
                ]
            ];
    
            $joinQuery = "FROM ticket";
    
            if($_GET['get'] == 'alllist'){
                $where = " tick_status IN (1,2,3,4) AND tick_caretaker = '$group'";
            } elseif($_GET['get'] == 'wait'){
                $where = " tick_status IN (1) AND tick_caretaker = '$group'";
            } elseif($_GET['get'] == 'process'){
                $where = " tick_status IN (2) AND tick_caretaker = '$group'";
            } else {
                $where = " tick_status IN (1,2,3,4) AND tick_caretaker = '$group'";
            }
            
    
            echo json_encode(
                SSP::simple($_GET, $sql_details_1, $table, $primaryKey, $columns, $joinQuery , $where)
            );
    
        }
        
    }

    

    