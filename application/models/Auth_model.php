<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function cekLogin(){        

        if(!$this->token()){
            redirect('auth/lostToken');
            return;
        }

        if($this->userdata){
			return true;
		}

    }

    public function userdata(){
        return $this->egovDB->where('id', $this->userdata()->user_id)->get('tb_user')->row();
    }

    public function menu(){
        $this->egovDB->where('id', $this->userdata()->user_id)->get('tb_user')->row();

        return $this->egovDB->where('id', $user->id)->get('tb_user')->row();
    }

    private function token(){
        if(!isset($_GET['token'])) return false;

        $token = $this->egovDB->where('token', $_GET['token'])->get('tb_token')->row();

        if(!$token) return false;
        if($token->token!=1) return false;
        
        return $token;
    }

    private function egovDB(){
        return $this->load->database('otherdb', TRUE);
    }

}