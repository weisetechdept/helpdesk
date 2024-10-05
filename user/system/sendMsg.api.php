<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    if(!isset($_SESSION['user_id'])){

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
        $id = $request->id;
        $msg = $request->msg;

        // send($sTokenFixedIT,$msg);

        $ticket = $db->where('tick_id',$id)->getOne('ticket');

        $tranData = array(
            'tran_where' => 'origin-comment',
            'tran_type' => '8',
            'tran_detail' => 'ต้นสังกัด : '.$msg,
            'tran_parent' => $id,
            'tran_status' => '1',
            'tran_datetime' => date('Y-m-d H:i:s')
        );
        $insert = $db->insert('transaction',$tranData);
        if($insert){

            /* send Notify Area */
            if($ticket['tick_caretaker'] == '1'){
                $token = $sTokenFixedIT;
            } elseif ($ticket['tick_caretaker'] == '2') {
                $token = $sTokenFixedK7;
            } elseif ($ticket['tick_caretaker'] == '3') {
                $token = $sTokenFixedTM;
            }
            $finalMsg = '[ต้นสังกัด] รหัส:'.$id.' แจ้งว่า '.$msg;
            send($token,$finalMsg);
            
            $api = array(
                'status' => 'success',
                'msg' => 'ส่งข้อความสำเร็จ'
            );
            
        } else {
            $api = array(
                'status' => 'error',
                'msg' => 'ไม่สามารถส่งข้อความได้'
            );
        }
        
    } else {
        $api = array(
            'status' => 'error',
            'msg' => 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้'
        );
    }

    echo json_encode($api);