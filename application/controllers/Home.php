<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		is_logged_in();
    }

    public function index(){
        $user_id         = $this->session->userdata('user_id');
        $jenis_pegawai   = $this->session->userdata('jenis_pegawai');
        $website         = $this->db->select('tb_websites.*, tb_user_roled_website.role_id')
		                                    ->where('tb_websites.is_hide_in_portal', null)
		                                    ->join('tb_user_roled_website', 'tb_user_roled_website.website_id=tb_websites.id AND tb_user_roled_website.user_id='.$user_id.' AND tb_user_roled_website.jenis_pegawai="'.$jenis_pegawai.'"', 'left')
		                                    ->get('tb_websites')->result_array();
		$data = [
			"page"				=> "home",
		    "website"           => $website,
		    "homepopup"         => $this->db->order_by('id', 'asc')->get('tb_pengaturan_popup')->row(),
		];
		$this->load->view('template/default', $data);
    }

}
