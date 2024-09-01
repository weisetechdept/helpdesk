<?php
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));
    $code = $request->search;

            $hd = $db->where('tick_code', $code)->get('ticket');

            foreach ($hd as $value) {
                if($value['tick_type'] == '1'){
                    $type = 'อุปกรณ์ IT / Software';
                } elseif($value['tick_type'] == '2') {
                    $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (มีรหัสทรัพยสิน)';
                } elseif($value['tick_type'] == '3') {
                    $type = 'เครื่องใช้สำนักงาน / เครื่องมือในการทำงาน (ไม่มีรหัสทรัพยสิน)';
                } elseif($value['tick_type'] == '4') {
                    $type = 'อาคารสถานที่ (มีรหัสทรัพยสิน)';
                } elseif($value['tick_type'] == '5') {
                    $type = 'อาคารสถานที่ (ไม่มีรหัสทรัพยสิน)';
                }
                $api['hd'][] = array(
                    'id' => $value['tick_id'],
                    'code' => $value['tick_code'],
                    'type' => $type,
                    'topic' => $value['tick_topic'],
                    'status' => $value['tick_status'],
                    'datetime' => $value['tick_datetime']
                );
            }
        
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