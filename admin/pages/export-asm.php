<?php 
    session_start();
    require_once '../../db-conn.php';

        $code = $_GET['code'];

        function statusTick($id){
            if($id == '0'){
                return 'รออนุมัติ(ผจก.)';
            } elseif($id == '1'){
                return 'รอดำเนินการ';
            } elseif($id == '2') {
                return 'ดำเนินการ';
            } elseif($id == '3') {
                return 'เสร็จสิ้น';
            } elseif($id == '4') {
                return 'ปิดงานแล้ว';
            } elseif($id == '10') {
                return 'ยกเลิก';
            }
        }

        function DateThai($strDate)
        {
            $strYear = date("y",strtotime($strDate));
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
            $strHour= date("H",strtotime($strDate));
            $strMin= date("i",strtotime($strDate));
        
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear $strHour:$strMin";
        } 

        $hd = $db->where('tick_code', $code)->get('ticket');

        $costTatal = 0;
        
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
                'datetime' => $value['tick_datetime'],
                'fixedcost' => $value['tick_fixedcost'],
                'detail' => $value['tick_detail']
            );

            $costTatal += $value['tick_fixedcost'];



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

    ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Export ASM</title>
        <style>
            body{
                font-family: "Garuda";
                font-size: 12px;
            }
            .text-center{
                text-align: center;
            }
            .text-right{
                text-align: right;
            }
            .assets td {
                padding: 5px;
                vertical-align:top;
                line-height: 1.4;
            }
        </style>
    </head>
    <body>

    <table style="width: 100%;">
        <tr>
            <td style="padding:0;vertical-align:top;"><h3>รายงานทรัพย์สินย์รหัส <?php echo $code;?></h3></td>
            <td style="padding:0;text-align:right;vertical-align:top;">วันที่ออกรายงาน<br /><?php echo DateThai(date('Y-m-d H:i:s'));?></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="padding:0;vertical-align:top;">
                <p style="margin:0;line-height: 1.4;margin-bottom:15px;">
                    ชื่อทรัพย์สิน : <?php echo $api['asm']['name'];?><br />
                    รหัสทรัพย์สิน : <?php echo $api['asm']['code'];?><br />
                    Serial No. : <?php echo $api['asm']['serial'];?><br />
                    ประเภททรัพย์สิน : <?php echo $api['asm']['type'];?><br />
                    หน่วยงานที่รับผิดชอบ : <?php echo $api['asm']['division'];?><br />
                    ผู้รับผิดชอบ : <?php echo $api['asm']['owner'];?><br />
                    ราคาทรัพย์สิน : <?php echo $api['asm']['price'];?> บาท
                </p>
            </td>
            <td style="padding:0;text-align:right;vertical-align:">
                <img style="width:120px;height:120px;" src="data:image/jpeg;base64,<?php echo $api['asm']['img'][0]; ?>">
            </td>
            <td style="padding:0;text-align:right;vertical-align:top;top;">
                <img style="width:120px;height:120px;float:right;" src="data:image/jpeg;base64,<?php echo $api['asm']['img'][1]; ?>">
            </td>
        </tr>
    </table>

        <h3 style="margin:0;">บันทีกข้อมูลการซ่อมทั้งหมดจากระบบ Help Desk</h3>
        <table class="assets" border="1" style="border-collapse: collapse;width:100%;">
            <thead>
                <tr>
                    <td width="35px" class="text-center">รหัส</td>
                    <td class="text-center">หัวข้อการแจ้ง</td>
                    <td class="text-center">รายละเอียด</td>
                    <td width="60px" class="text-center">ค่าใช้จ่าย</td>
                    <td class="text-center">สถานะ</td>
                    <td class="text-center">วันที่แจ้ง</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($api['hd'] as $key => $value) { ?>
                    <tr>
                        <td class="text-center"><?php echo $value['id']; ?></td>
                        <td><?php echo $value['topic']; ?></td>
                        <td><?php echo $value['detail']; ?></td>
                        <td class="text-right"><?php echo number_format($value['fixedcost']); ?></td>
                        <td class="text-center"><?php echo statusTick($value['status']); ?></td>
                        <td><?php echo DateThai($value['datetime']); ?></td>
                    </tr>
            <?php } ?>
                <tr>
                    <td colspan="3">รวมค่าใช้จ่ายในการซ่อนที่บันทึกในระบบ Help Desk</td>
                    <td class="text-right"><?php echo number_format($costTatal); ?></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>

        <br />

        <h3 style="margin:0;">บันทีกข้อมูลการซ่อมทั้งหมดจากระบบ ASM</h3>
        <table class="assets" border="1" style="border-collapse: collapse;width:100%;">
            <thead>
                <tr>
                    <td width="35px" class="text-center">รหัส</td>
                    <td class="text-center">หัวข้อการแจ้ง</td>
                    <td class="text-center">รายละเอียด</td>
                    <td width="60px" class="text-center">ค่าใช้จ่าย</td>
                    <td class="text-center">สถานะ</td>
                    <td class="text-center">วันที่แจ้ง</td>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($api['asm']['assetRepairs'] as $key => $value) { ?>
                    <tr>
                        <td class="text-center"><?php echo $value->id; ?></td>
                        <td><?php echo $value->title; ?></td>
                        <td><?php echo $value->detail; ?></td>
                        <td class="text-right
                        "><?php echo number_format($value->cost); ?></td>
                        <td class="text-center"><?php echo $value->status; ?></td>
                        <td><?php echo DateThai($value->created_at); ?></td>
                    </tr>
            <?php } ?>
            </tbody>

        </table>
    </body>
</html>
<?php
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => __DIR__ . '/export/'
    ]);

    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output();
?>