<?php
	session_start();
    require_once '../../db-conn.php';
	date_default_timezone_set("Asia/Bangkok");

    
    /* HR */
    $sToken = "nbmhKeadM6zUJ9ZkxFMhNzYK74L8mCgQbYcyO235le6";
    $sMessage = "มีการแจ้งซ้อมใหม่ กรุณาตรวจสอบ";

    /* IT */
    //$sToken = "ssOkKxxfRq1amv4hkmVQUOsKWfN9FYeRik5k2ozYFcK"; 
	$sMessage = "มีการแจ้งซ้อมใหม่ กรุณาตรวจสอบ";

    echo send($sToken,$sMessage,'');

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

		if(curl_error($chOne)) 
		{ 
			return json_encode(array('status' => '400'));
		} else {
			return json_encode(array('status' => '200'));
		} 

		curl_close( $chOne );  

    }

		
        
        
?>