<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

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

    if($_GET['po'] == 'editCode'){
        $data = array(
            'tick_code' => $request->code
        );
        $update = $db->where('tick_id', $request->id)->update('ticket', $data);
        if($update){
            $api = array(
                'status' => 'success',
                'message' => 'บันทึกข้อมูลเรียบร้อย'
            );
        } else {
            $api = array(
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }
    }

    if($_GET['po'] == 'cancel'){
        $request = json_decode(file_get_contents('php://input'));
        $id = $request->id;
        $status = $request->status;
        $update = $db->where('tick_id', $id)->update('ticket', ['tick_status' => '10']);
        if($update){
            
            $tdata = array(
                'tran_where' => 'ticket',
                'tran_detail' => 'รายการแจ้งซ้อมยกเลิก',
                'tran_parent' => $id,
                'tran_status' => $status,
                'tran_datetime' => date('Y-m-d H:i:s')
            );

            if($db->insert('transaction', $tdata)){
                $api = array(
                    'status' => 'success',
                    'message' => 'บันทึกข้อมูลเรียบร้อย'
                );
            } else {
                $api = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                );
            }

        } else {
            $api = array(
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }
    }

    if($_GET['po'] == 'finish'){
        $request = json_decode(file_get_contents('php://input'));
        $id = $request->id;
        $status = $request->status;
        $update = $db->where('tick_id', $id)->update('ticket', ['tick_status' => '3']);
        if($update){
            
            $tdata = array(
                'tran_where' => 'ticket',
                'tran_detail' => 'รายการแจ้งซ้อมเสร็จสิ้น',
                'tran_parent' => $id,
                'tran_status' => $status,
                'tran_datetime' => date('Y-m-d H:i:s')
            );

            if($db->insert('transaction', $tdata)){
                $api = array(
                    'status' => 'success',
                    'message' => 'บันทึกข้อมูลเรียบร้อย'
                );
            } else {
                $api = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                );
            }

        } else {
            $api = array(
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }
    }

    if($_GET['po'] == 'stp1'){

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

            $v = $db->where('vend_id', $vendor)->getOne('vendor');
            $f = $db->where('type_id', $fix)->getOne('fix_type');

            $tdata = array(
                'tran_where' => 'vendor-fixtype',
                'tran_detail' => 'เปลี่ยนผู้รับเรื่องเป็น '.$v['vend_name'].' และประเภทการซ่อมเป็น '.$f['type_name'],
                'tran_parent' => $id,
                'tran_status' => '2',
                'tran_datetime' => date('Y-m-d H:i:s')
            );

            if($db->insert('transaction', $tdata)){

                $care = $db->where('tick_id', $id)->getOne('ticket');
                if($care['tick_caretaker'] == '1'){
                    $sToken = "nbmhKeadM6zUJ9ZkxFMhNzYK74L8mCgQbYcyO235le6";
                } elseif($care['tick_caretaker'] == '2') {
                    $sToken = "ssOkKxxfRq1amv4hkmVQUOsKWfN9FYeRik5k2ozYFcK"; 
                }
    
                $sMessage = "[จ่ายงาน] งานซ่อมหมายเลข ".$id." ได้มอบหมายให้ ".$v['vend_name']." ,ประเภท ".$f['type_name']." - https://helpdesk.toyotaparagon.com/admin/fix/".$id;
                send($sToken,$sMessage);

                $api = array(
                    'status' => 'success',
                    'message' => 'บันทึกข้อมูลเรียบร้อย'
                );
            } else {
                $api = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                );
            }

        } else {
            $api = array(
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }
    }

    if($_GET['po'] == 'stp2'){

        function status($id){
            if($id == '1'){
                return 'เปลี่ยนสถานะเป็นกำลังดำเนินการ';
            } elseif($id == '2'){
                return 'เปลี่ยนสถานะเป็นขออนุมัติซ่อม (มีค่าใช้จ่าย)';
            } elseif($id == '3'){
                return 'เปลี่ยนสถานะเป็นรออะไหล่';
            } elseif($id == '4'){
                return 'เปลี่ยนสถานะเป็นรอส่งงานนอก';
            } 
        }

        $id = $request->id;
        $status = $request->status;
        $detail = $request->detail;

        $data = array(
            'tick_status' => '2',
        );

        $update = $db->where('tick_id', $id)->update('ticket', $data);
        if($update){

            if($detail !== ''){
                $detail = ' ('.$detail.')';
            }

            $tdata = array(
                'tran_where' => 'oparation',
                'tran_detail' => status($status).''.$detail,
                'tran_parent' => $id,
                'tran_status' => $status,
                'tran_datetime' => date('Y-m-d H:i:s')
            );

            if($db->insert('transaction', $tdata)){
                $api = array(
                    'status' => 'success',
                    'message' => 'บันทึกข้อมูลเรียบร้อย'
                );
            } else {
                $api = array(
                    'status' => 'error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                );
            }

        } else {
            $api = array(
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            );
        }

    }

    echo json_encode($api);