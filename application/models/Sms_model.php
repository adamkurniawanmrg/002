<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sms_model extends CI_Model
{

    private $userKey = "dqolhx";
    private $passKey = "20j5k6rc051egqbjpkrr-alpha";
    private $token   = "abc123456";

    public function send($numberPhone, $message){ 
        error_reporting(0);
        $token = "OWDoChfRX6AM9gxXm5smonbn22I8rj5rJIzeNkxmsCnuGe87VX";

        $url = 'https://app.ruangwa.id/api/send_message';
        $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT,30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
               'token'    => $token,
               'number'     => $numberPhone,
               'message'   => $message,
            ));
           curl_setopt($curl, CURLOPT_HTTPHEADER,'Content-Type: application/x-www-form-urlencoded');
        
        $response = curl_exec($curl); 
        curl_close($curl);
        return $response;

        $url         = "http://wa-gateway.labura.go.id/api.php?token=".$this->token."&act=SEND";
        $body        = 'nomor_tujuan='.$numberPhone.'&pesan='.urlencode($message);

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);

        return;

        $url = "https://alpha.zenziva.net/apps/smsapi.php";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$this->userKey.'&passkey='.$this->passKey.'&nohp='.$numberPhone.'&pesan='.urlencode($message));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);

        $XMLdata = new SimpleXMLElement($results);
        $status = $XMLdata->message[0]->text."";

        return $status;

    }


}
