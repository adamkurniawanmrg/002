<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set("Asia/Jakarta");
   }

    public function role_api($website_id=0, $method=false, $role_id=0){
        $website = $this->db
                        ->select('tb_websites.*, tb_api.user_key, tb_api.pass_key, tb_source_code.file_get_role')
                        ->where('tb_websites.id', $website_id)
                        ->join('tb_api', 'tb_api.website_id=tb_websites.id','left')
                        ->join('tb_source_code', 'tb_source_code.website_id=tb_websites.id','left')
                        ->get('tb_websites')
                        ->row();

        if(!$website) return false;

        $posts ='user_key='.$website->user_key.'&pass_key='.$website->pass_key.'&method='.$method;

        if($method=='getone'){
            $posts .= '&role_id='.$role_id;
        }
        if(!$website->file_get_role) return false;

        $is_http = [15, 16];

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, (in_array($website->id, $is_http) ? "http":"https").'://'.$website->domain.'/'.$website->file_get_role);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $posts);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
        
        return json_decode($results, true);
    }	


}
