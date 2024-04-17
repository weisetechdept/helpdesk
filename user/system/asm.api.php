<?php 
    $code = $_GET['code'];

   
    if(!empty($code)){
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

        $api = array(
            'code' => $results->id,
            'name' => $results->name,
            'serial' => $results->serialNo,
            'type' => $results->assetTypeName,
            'division' => $results->divisionName,
            'owner' => $results->owner,
            'price' => $results->price,
            'importedDate' => $results->importedDate,

        );
    } else {
        $api = array('status' => 'error', 'message' => 'not found');
        
    }

    echo json_encode($api);
    
?>
