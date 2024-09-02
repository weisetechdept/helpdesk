<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once '../../db-conn.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

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

    if($type = '2' || $type = '3' || $type = '4' || $type = '5'){
        $caretaker = '2';
    } else {
        $caretaker = '1';
    }

    $data = array(
        'tick_caretaker' => $caretaker,
        'tick_type' => $type,
        'tick_topic' => $topic,
        'tick_detail' => $detail,
        'tick_code' => strtoupper($code),
        'tick_tel' => $tel,
        'tick_owner' => $user['user_id'],
        'tick_vendor' => '0',
        'tick_fix_type' => '0',
        'tick_dept' => $user['user_dept'],
        'tick_fixedcost' => '0',
        'tick_status' => '0',
        'tick_finished' => date('Y-m-d H:i:s'),
        'tick_datetime' => date('Y-m-d H:i:s')
    );
    $id = $db->insert('ticket', $data);
    if($id){

        $hash = md5(uniqid($user['user_id'].''.rand(0,999999), true));
        $data = array(
            'veri_to' => 'pyoungys@gmail.com',
            'veri_code' => $hash,
            'veri_parent' => $id,
            'veri_status' => '0',
            'veri_sign' => date('Y-m-d H:i:s'),
            'veri_datetime' => date('Y-m-d H:i:s')
        );

        $verify = $db->insert('verify_ticket', $data);
        if($verify){

            $mail = new PHPMailer();
            $body = "มีการขออนุมัติซ่อมในแผนกของคุณ (คลิกลิ้งค์เพื่อดูรายละเอียด และพิจารณา) <br /> https://helpdesk.toyotaparagon.com/verify/".$hash." <br /> โปรดอย่าตอบกลับอีเมลล์นี้ หากมีข้อสงสัยกรุณาติดต่อผ่านทางฝ่ายทรัพย์สิน";
            $mail->CharSet = "utf-8";
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = $mail_host;
            $mail->Port = $mail_port;
            $mail->Username = $mail_user;
            $mail->Password = $mail_pass;

            $mail->SetFrom("no-reply@weisetechnika.com", "HelpDesk System - Toyota Paragon Motor");
            $mail->AddReplyTo("no-reply@weisetechnika.com", "HelpDesk System - Toyota Paragon Motor");
            $mail->Subject = "รายการขออนุมัติซ่อมใหม่ ในแผนกของคุณ";

            $mail->MsgHTML($body);

            $mail->AddAddress("pyoungys@gmail.com", "recipient1"); // ผู้รับคนที่หนึ่ง

            if($mail->Send()) {

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
                $api = array('status' => 'error', 'message' => 'Send email failed');
            }

        } else {
            $api = array('status' => 'error', 'message' => 'Create verify code failed');
        }


    } else {
        $api = array('status' => 'error');
    }

    echo json_encode($api);