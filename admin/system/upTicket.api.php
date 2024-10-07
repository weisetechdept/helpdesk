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

    if($_GET['po'] == 'upComment'){

        $id = $request->id;
        $comment = $request->detail;
        $type = $request->type;

        $data = array(
            'tran_where' => 'fixer_comment',
            'tran_type' => $type,
            'tran_detail' => 'ผู้รับงาน : '.$comment,
            'tran_parent' => $id,
            'tran_status' => '1',
            'tran_datetime' => date('Y-m-d H:i:s')
        );

        $insert = $db->insert('transaction', $data);
        if($insert){
            $api = array('status' => 'success');
        } else {
            $api = array('status' => 'error', 'message' => 'Insert comment failed');
        }

    }

    if($_GET['po'] == 'editCode'){
        $data = array(
            'tick_code' => $request->code,
            'tick_dept' => $request->deptId
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
        $detail = $request->detail;
        $status = $request->status;
        $update = $db->where('tick_id', $id)->update('ticket', ['tick_status' => '10']);
        if($update){
            
            $tdata = array(
                'tran_where' => 'ticket',
                'tran_type' => '1',
                'tran_detail' => 'รายการแจ้งซ้อมยกเลิก เหตุผล : '.$request->detail,
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

    if($_GET['po'] == 'uploadImg'){

        $id = $_POST['id'];

        if(isset($_FILES['file_upload'])){
            $image = $_FILES['file_upload']['tmp_name'];
            $type = mime_content_type($image);
            $name = basename($image);

            $url = 'https://api.cloudflare.com/client/v4/accounts/1adf66719c0e0ef72e53038acebcc018/images/v1';
            $cfile = curl_file_create($image, $type, $name);
            $data = array("file" => $cfile);
            
            $headers = [ 
                'Authorization: Bearer x2skj57v2poPW8UxIQGqBACBxkJ4Glg42lVhbDPe',
                'Content-Type: multipart/form-data'
            ];
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response, true);

            $data = array(
                'imag_link' => $response['result']['variants'][1],
                'imag_code' => $response['result']['id'],
                'imag_parent' => $id,
                'imag_status' => '1',
                'imag_datetime' => date('Y-m-d H:i:s')
            );

            $upload = $db->insert('images', $data);
            if($upload){
                $api = array('status' => 'success');
            } else {
                $api = array('status' => 'error', 'message' => 'Upload image failed');
            }
        }
    }

    if($_GET['po'] == 'finish'){
        $request = json_decode(file_get_contents('php://input'));
        $id = $request->id;
        $status = $request->status;
        $cost = $request->fixed_cost;

        $update = $db->where('tick_id', $id)->update('ticket', ['tick_status' => '3','tick_fixedcost' => $cost,'tick_finished' => date('Y-m-d H:i:s')]);
        if($update){
            
            $tdata = array(
                'tran_where' => 'ticket',
                'tran_type' => '1',
                'tran_detail' => 'รายการแจ้งซ้อมเสร็จสิ้น มีค่าใชเจ่ายทั้งหมด '.number_format($cost).' บาท',
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
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้ (Transaction)'
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
                'tran_type' => '1',
                'tran_detail' => 'เปลี่ยนผู้รับเรื่องเป็น '.$v['vend_name'].' และประเภทการซ่อมเป็น '.$f['type_name'],
                'tran_parent' => $id,
                'tran_status' => '2',
                'tran_datetime' => date('Y-m-d H:i:s')
            );
 
            if($db->insert('transaction', $tdata)){

                $care = $db->where('tick_id', $id)->getOne('ticket');
                if($care['tick_caretaker'] == '1'){
                    $sToken = "Ey09FWoSKYIn0dCLzKodE0mYIAaRrMEvFl1eMSSFo1u";
                } elseif($care['tick_caretaker'] == '2') {
                    $sToken = "x9D0NLb762C3fiAvlA8VTcZSvujibjkwIHRwmaashGY"; 
                } elseif($care['tick_caretaker'] == '3') {
                    $sToken = "Jv05BoiLmQ3eYVlltdOiAtW05e5oHjuD0vMCB9j68Ru"; 
                }
    
                $sMessage = "[จ่ายงาน] งานซ่อมหมายเลข ".$id." ได้มอบหมายให้ ".$v['vend_name']." ,ประเภท ".$f['type_name']." - https://helpdesk.toyotaparagon.com/admin/fix/".base64_encode($id);
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
                'tran_type' => '1',
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