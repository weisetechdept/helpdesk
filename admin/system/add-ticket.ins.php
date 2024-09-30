<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';

    $type = $_POST['type'];
    $topic = $_POST['topic'];
    $detail = $_POST['detail'];
    $code = $_POST['code'];
    $tel = $_POST['tel'];
    
    function sanitizeInput($input) {
        return $input;
    }

    $owner = $_SESSION['hd_code'];
    $user = $db->where('user_code',$owner)->getOne('user');

    if($_SESSION['adminGroup'] == '2'){
        $dept = '31';
        $adowner = '90002';
    } elseif($_SESSION['adminGroup'] == '3') {
        $dept = '15';
        $adowner = '90003';
    } elseif($_SESSION['adminGroup'] == '1') {
        $dept = '26';
        $adowner = '90001';
    }

    $data = array(
        'tick_caretaker' => $_SESSION['adminGroup'],
        'tick_type' => $type,
        'tick_topic' => $topic,
        'tick_detail' => $detail,
        'tick_code' => strtoupper($code),
        'tick_tel' => $tel,
        'tick_owner' => $adowner,
        'tick_vendor' => '0',
        'tick_fix_type' => '0',
        'tick_dept' => $dept,
        'tick_fixedcost' => '0',
        'tick_status' => '1',
        'tick_finished' => date('Y-m-d H:i:s'),
        'tick_datetime' => date('Y-m-d H:i:s')
    );
    $id = $db->insert('ticket', $data);
    if($id){
        //$api = array('status' => 'success', 'message' => 'Ticket created');
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
    
        } else {

            $api = array('status' => 'success');

        }

    } else {
        $api = array('status' => 'error', 'message' => 'Create ticket failed');
    }

    echo json_encode($api);