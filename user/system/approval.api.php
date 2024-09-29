<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';

    function send($token,$message,$where){

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
/*
		if(curl_error($chOne)) 
		{ 
			return json_encode(array('status' => '400'));
		} else {
			return json_encode(array('status' => '200'));
		} 

		curl_close( $chOne );  
*/
    }

    $request = json_decode(file_get_contents('php://input'));

    $tid = $request->id;

    $data = array(
        'tick_status' => '1'
    );
    $update = $db->where('tick_id',$tid)->update('ticket',$data);

    if($update){
        $tdata = $db->where('tick_id',$tid)->getOne('ticket');
        if($tdata['tick_caretaker'] == '1'){

            $sToken = "nbmhKeadM6zUJ9ZkxFMhNzYK74L8mCgQbYcyO235le6";
            $sMessage = "มีการแจ้งซ้อมใหม่ กรุณาตรวจสอบ";
            send($sToken,$sMessage,'');
            
        } elseif($tdata['tick_caretaker'] == '2'){

            $sToken = "ssOkKxxfRq1amv4hkmVQUOsKWfN9FYeRik5k2ozYFcK"; 
	        $sMessage = "มีการแจ้งซ้อมใหม่ กรุณาตรวจสอบ";
            send($sToken,$sMessage,'');

        } elseif($tdata['tick_caretaker'] == '3') {
            $sToken = "hMEJa1YtlGTQ2B5iby5CDvuPeNSEUlYxiepAbYFeAyc"; 
	        $sMessage = "มีการแจ้งซ้อมใหม่ กรุณาตรวจสอบ";
            send($sToken,$sMessage,'');
        }

        $api = array(
            'status' => 'success',
            'message' => 'Ticket Approved'
        );
    } else {
        $api = array(
            'status' => 'error',
            'message' => 'Failed to approve ticket'
        );
    }

    echo json_encode($api);