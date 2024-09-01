<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");
    
    $id = $_GET['id'];
    $detail = $db->where('tick_id',$id)->getOne('ticket');
    $api = array();

    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array(
            "0"=>"",
            "1"=>"มกราคม",
            "2"=>"กุมภาพันธ์",
            "3"=>"มีนาคม",
            "4"=>"เมษายน",
            "5"=>"พฤษภาคม",
            "6"=>"มิถุนายน", 
            "7"=>"กรกฎาคม",
            "8"=>"สิงหาคม",
            "9"=>"กันยายน",
            "10"=>"ตุลาคม",
            "11"=>"พฤศจิกายน",
            "12"=>"ธันวาคม"
        );
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear $strHour:$strMinute";
    }

    if(isset($_SESSION['hd_login'])){
        
        $db->join('user u','t.tick_owner = u.user_id','LEFT');
        $db->join('user_group g','t.tick_dept = g.usrg_id','LEFT');
        $emp = $db->getOne('ticket t');

        if($emp['usrg_branch'] == '1'){
            $branch = 'สำนักงานใหญ่';
        } elseif($emp['usrg_branch'] == '2') {
            $branch = 'สาขาตลาดไท';
        }

        $division = $emp['usrg_name'];
        $owner = $emp['user_first_name'].' '.$emp['user_last_name'];

        if($detail['tick_type'] == '1'){
            $type = 'อุปกรณ์ IT / Software';
        } elseif($detail['tick_type'] == '2') {
            $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (มีรหัสทรัพยสิน)';
        } elseif($detail['tick_type'] == '3') {
            $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (ไม่มีรหัสทรัพยสิน)';
        } elseif($detail['tick_type'] == '4') {
            $type = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
        } elseif($detail['tick_type'] == '5') {
            $type = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
        }

        if($detail['tick_caretaker'] == '1'){
            $caretaker = 'อุปกรณ์ IT / Software';
        } elseif($detail['tick_caretaker'] == '2') {
            $caretaker = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (มีรหัสทรัพยสิน)';
        } elseif($datail['tick_caretaker'] == '3') {
            $caretaker = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (ไม่มีรหัสทรัพยสิน)';
        } elseif($detail['tick_caretaker'] == '4') {
            $caretaker = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
        } elseif($detail['tick_caretaker'] == '5') {
            $caretaker = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
        }

        if($detail['tick_code'] == ''){
            $detail['tick_code'] = 'ไม่ระบุ';
        } else {
            $detail['tick_code'] = $detail['tick_code'];
        }

        $api = array(
            'id' => $detail['tick_id'],
            'caretaker' => $caretaker,
            'type' => $type,
            'topic' => $detail['tick_topic'],
            'detail' => $detail['tick_detail'],
            'code' => $detail['tick_code'],
            'owner' => $owner,
            'branch' => $branch,
            'division' => $division,
            'status' => $detail['tick_status'],
            'datetime' => DateThai($detail['tick_datetime'])
        );

        $img = $db->where('imag_parent',$id)->where('imag_status',1)->get('images');
        if($db->count > 0){
            foreach ($img as $value) {
                $api['images'][] = array(
                    'link' => $value['imag_link'],
                    'status' => $value['imag_status']
                );
            }
        } else {
            $api['images'] = array();
        }
        
    } else {
        $api = array('status' => 'error', 'message' => 'Permission denied');
    }

    $trans = $db->orderBy('tran_id','DESC')->where('tran_parent',$id)->get('transaction');
    if(isset($trans) && count($trans) > 0){

        $no = count($trans);
        $noAll = $db->count;

        for ($i = 0; $i < 2; $i++) {
            $api['transaction'][] = array(
                'id' => $no,
                'detail' => $trans[$i]['tran_detail'],
                'datetime' => DateThai($trans[$i]['tran_datetime'])
            );
            $no--;
        }

        foreach ($trans as $value) {
            $api['trans_all'][] = array(
                'id' => $noAll,
                'detail' => $value['tran_detail'],
                'datetime' => $value['tran_datetime']
            );
            $noAll--;
        }
        
    } else {
        $api['transaction'][] = array(
            'id' => '0',
            'detail' => 'ไม่มีข้อมูล',
            'datetime' => '0000-00-00 00:00:00'
        );
    }


    $code = $detail['tick_code'];
    
        $url = 'https://asset.thaismartcontract.com/api/info?id='.$code;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $results = json_decode($resp);

        $img = array();
        $count = 0;
        foreach ($results->importPhotos as $key => $value) {
            if ($count < 3) {
            $img[] = $value->base64;
            $count++;
            } else {
            break;
            }
        }

        foreach ($results->importPhotos as $key => $value) {
            $imgAll[] = $value->base64;
        }

        if ($results->id == null) {
            $api['asm'] = array(
                'getStatus' => 'error',
                'message' => 'ไม่พบข้อมูล'
            );
        } else {
            $api['asm'] = array(
                'getStatus' => 'success',
                'code' => $results->id,
                'name' => $results->name,
                'serial' => $results->serialNo,
                'type' => $results->assetTypeName,
                'division' => $results->divisionName,
                'owner' => $results->owner,
                'price' => number_format($results->price),
                'locationName' => $results->locationName,
                'img' => $img,
                'imgAll' => $imgAll,
                'assetRepairs' => $results->assetRepairs
            );
        }
 
    echo json_encode($api);

    