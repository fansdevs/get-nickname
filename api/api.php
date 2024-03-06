<?php
$apiKeys = 'D6bMLXuhLdsb6hqXMxAz9aCFwm86HK2JcnMjaaWYnjcgjVSnPfZJk271iUS1AgNF';
    $merchantCodes = 'U6jeTFhL';
    $signe = $merchantCodes.$apiKey;
    $sign = md5($signe);
    $curl1 = curl_init();
    curl_setopt_array($curl1, array(
        CURLOPT_URL => 'https://vip-reseller.co.id/api/game-feature',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('key' => $apiKey, 'sign' => $sign, 'type' => 'get-nickname', 'code' => $code, 'target' => $target, 'additional_target' => $additional_target),
    ));
    $response1 = curl_exec($curl1);
    curl_close($curl1);
    $hasils = json_decode($response1, true);
    echo $response1;
    echo $nickname = $hasils['data'];
?>
