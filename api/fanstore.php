<?php
$curl = curl_init();

curl_setopt_array($curl, array(

  CURLOPT_URL => 'https://fanstore.site/api/services.php',

  CURLOPT_RETURNTRANSFER => true,

  CURLOPT_ENCODING => '',

  CURLOPT_MAXREDIRS => 10,

  CURLOPT_TIMEOUT => 0,

  CURLOPT_FOLLOWLOCATION => true,

  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

  CURLOPT_CUSTOMREQUEST => 'POST',

  CURLOPT_POSTFIELDS => array(

      'api_key' => $apiKey.$api_key_fanstore,

      'type' => 'game-premium',

  ),

));

$response = curl_exec($curl);

curl_close($curl);

echo $response;

$hasil = json_decode($response, true);
?>
