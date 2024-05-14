<?php 
    session_start();
    require_once '../../db-conn.php';
    date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));
    $branch = $request->branch;

    if($branch == '0') {
        $api[] = array(
            'id' => '0',
            'name' => 'โปรดเลือกแผนก'
        );
    } else {
        $dept = $db->where('usrg_branch',$branch)->where('usrg_status',1)->get('user_group');
        foreach($dept as $d) {

            if($d['usrg_branch'] == '1'){
                $branch = 'สำนักงานใหญ่';
            } elseif($d['usrg_branch'] == '2') {
                $brance = 'ตลาดไท';
            }

            $api[] = array(
                'id' => $d['usrg_id'],
                'name' => $branch.' - '.$d['usrg_name']
            );
        }
    }

    echo json_encode($api);