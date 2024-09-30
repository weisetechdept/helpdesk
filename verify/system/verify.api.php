<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';

    function DateThai($strDate)
    {
        $strYear = date("y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear - $strHour:$strMinute";
    } 

    function send($token,$message){

        $sToken = $token;
		$sMessage = $message;

		$chOne = curl_init(); 
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt( $chOne, CURLOPT_POST, 1); 
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
		$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec( $chOne ); 

		curl_close( $chOne );  

    }

    $request = json_decode(file_get_contents('php://input'));

    if($_GET['get'] == 'approval'){
        $code = $request->code;

        $db->join('verify_ticket v', 'v.veri_parent=t.tick_id', 'LEFT');
        $db->where('v.veri_code', $code);
        $ticket = $db->getOne('ticket t');

        $data = array(
            'tick_status' => '1'
        );
        $id = $db->where('tick_id', $ticket['tick_id'])->update('ticket', $data);
        if($id){

            $db->join('user_group ug','ug.usrg_id = t.tick_dept','LEFT');
            $tdata = $db->where('tick_id',$ticket['tick_id'])->getOne('ticket t');
            function branch($id) {
                if($id == '1'){
                    return 'สำนักงานใหญ่';
                }elseif($id == '2') {
                    return 'ตลาดไท';
                }
            }

            // if($tdata['tick_type'] == '1'){
            //     $sToken = "nbmhKeadM6zUJ9ZkxFMhNzYK74L8mCgQbYcyO235le6";
            // } else {
            //     $sToken = "ssOkKxxfRq1amv4hkmVQUOsKWfN9FYeRik5k2ozYFcK"; 
            // }

            if($tdata['tick_caretaker'] == '1'){
                $sToken = "Ey09FWoSKYIn0dCLzKodE0mYIAaRrMEvFl1eMSSFo1u";

            } elseif($tdata['tick_caretaker'] == '2') {

                $sToken = "x9D0NLb762C3fiAvlA8VTcZSvujibjkwIHRwmaashGY"; 

            } elseif($tdata['tick_caretaker'] == '3') {

                $sToken = "Jv05BoiLmQ3eYVlltdOiAtW05e5oHjuD0vMCB9j68Ru"; 

            }

            $sMessage = "[รับแจ้ง] มีการแจ้งซ้อมใหม่ หมายเลข ".$tdata['tick_id']." จาก ".$tdata['usrg_name']." (".branch($tdata['usrg_branch']).") กรุณาตรวจสอบ";
            send($sToken,$sMessage);

            $upVerify = $db->where('veri_code', $code)->update('verify_ticket', array('veri_status' => '1','veri_sign' => date('Y-m-d H:i:s')));
            if($upVerify){
                $api['approval'] = array(
                    'status' => 'success',
                    'message' => 'อนุมัติเรียบร้อย'
                );
            } else {
                $api['approval'] = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถอนุมัติได้'
                );
            }
        } else {
            $api['approval'] = array(
                'status' => 'error',
                'message' => 'ไม่สามารถอนุมัติได้'
            );
        }

    }

    if($_GET['get'] == 'reject'){

        $code = $request->code;

        $db->join('verify_ticket v', 'v.veri_parent=t.tick_id', 'LEFT');
        $db->where('v.veri_code', $code);
        $ticket = $db->getOne('ticket t');

        $data = array(
            'tick_status' => '10'
        );
        $id = $db->where('tick_id', $ticket['tick_id'])->update('ticket', $data);
        if($id){
            $upVerify = $db->where('veri_code', $code)->update('verify_ticket', array('veri_status' => '10','veri_sign' => date('Y-m-d H:i:s')));
            if($upVerify){
                $api['approval'] = array(
                    'status' => 'success',
                    'message' => 'อนุมัติเรียบร้อย'
                );
            } else {
                $api['approval'] = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถอนุมัติได้'
                );
            }
        } else {
            $api['approval'] = array(
                'status' => 'error',
                'message' => 'ไม่สามารถอนุมัติได้'
            );
        }
        
    }

    if($_GET['get'] == 'detail'){

        $code = $request->code;

        $db->join('verify_ticket v', 'v.veri_parent=t.tick_id', 'LEFT');
        $db->where('v.veri_code', $code);
        $ticket = $db->getOne('ticket t');
        
        $api = array(); // Add the declaration of $api variable
        
        if($ticket['tick_status'] !== '0'){
        $api['detail'] = array(
                'status' => 'error',
                'message' => 'ไม่พบข้อมูล'
            );
        } else {
            $img =  $db->where('imag_parent', $ticket['tick_id'])->getOne('images');
        
            function type($id){
                if($id == 1){
                    $type = 'อุปกรณ์ IT / Software';
                }else if($id == 2){
                    $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (มีรหัสทรัพยสิน)';
                }else if($id == 3){
                    $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (ไม่มีรหัสทรัพยสิน)';
                }else if($id == 4){
                    $type = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
                }else if($id == 5){
                    $type = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
                }
                return $type;
            }
        
            $api['detail'] = array(
                'status' => 'success',
                'tick_id' => $ticket['tick_id'],
                'tick_type' => type($ticket['tick_caretaker']),
                'veri_datetime' => DateThai($ticket['tick_datetime']),
                'tick_topic' => $ticket['tick_topic'],
                'tick_detail' => $ticket['tick_detail'],
                'tick_tel' => $ticket['tick_tel'],
                'tick_status' => $ticket['tick_status'],
                'tick_img' => $img['imag_link']
            );
        }

    }
    

    echo json_encode($api);