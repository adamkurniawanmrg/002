<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redirect extends CI_Controller {
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
    }

    public function getauthenticate($website_id=false){

        if(!$website_id){ 
            $this->bsalert('<strong>Maaf !</strong> Invalid Url !', 'danger');
            redirect('home?token='.$_GET['token']);
            return;
            
        }
        
        $website = $this->db->where('id', $website_id)->get('tb_websites')->row();
        
        if(!$website){ 
            $this->bsalert('<strong>Maaf !</strong> Website tidak ditemukan !', 'danger');
            redirect('home?token='.$_GET['token']);
            return;
            
        }

        $cekAccess = $this->db->where('website_id', $website->id)->where('user_id', $this->session->userdata('user_id'))->get('tb_user_roled_website')->row();
        
        if(!$cekAccess){ 
            $this->bsalert('<strong>Maaf !</strong> Anda tidak dapat mengakses website ini!', 'danger');
            redirect('home?token='.$_GET['token']);
            return;
            
        }
        
        $is_http = [15, 16];
        if($website->id==12 || $website->id==14 || $website->id==16 || $website->id==17 || $website->id==18){
            header("location:".(in_array($website->id, $is_http) ? "http":"https")."://".$website->domain);
        }else{

            header("location:".(in_array($website->id, $is_http) ? "http":"https")."://".$website->domain.($website->id==15 ? "/index.php":null)."/auth/login/".$cekAccess->user_id."/".$this->session->userdata('token'));
        }

    }

    private function bsalert($capt, $class){
            return $this->session->set_flashdata('pesan', '
                    <div class="alert alert-'.$class.'" role="alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        '.$capt.'
                    </div>');

    }

}
