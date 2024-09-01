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

        $api = array(
            'code' => $results->id,
            'name' => $results->name,
            'serial' => $results->serialNo,
            'type' => $results->assetTypeName,
            'division' => $results->divisionName,
            'owner' => $results->owner,
            'price' => number_format($results->price),
            'locationName' => $results->locationName,
            'img' => $img,
            'imgAll' => $imgAll
        );

    } else {
        $api = array('status' => 'error', 'message' => 'not found');
        
    }

    print_r($api);

    //echo json_encode($api);
    
?>
