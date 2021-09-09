<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper_model extends CI_Model
{
    public $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
    public $bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public function setFlashdata($a, $b){
        $this->session->set_userdata([$a=>$b]);
        return;
    }
    public function flashdata($a){
        $msg = $this->session->userdata($a) ? $this->session->userdata($a) : null;
        if($this->session->userdata($a)) $this->session->unset_userdata($a);
        return $msg;
    }
    
}