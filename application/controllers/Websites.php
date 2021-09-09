<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Websites extends CI_Controller {
	public function __construct(){
        parent::__construct();
         $this->load->model(['Website_model']);
		date_default_timezone_set("Asia/Jakarta");
		is_logged_in();
    }

    public function index(){
		$data = [
			"page"				=> "websites/datawebsites",
			"website"           => $this->db->select('tb_websites.*, tb_api.id api_id')->join('tb_api','tb_api.website_id=tb_websites.id','left')->order_by('tb_websites.id','desc')->get('tb_websites')->result_array(),
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
				base_url("assets/vendors/bs-custom-file-input/bs-custom-file-input.min.js"),
				base_url("assets/js/file-upload.js"),
			
				base_url("assets/js/select2.js"),
			
			],
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
			"javascriptCode"	=> "
    			(function($) {
    				'use strict';
    				$(function() {
    				  $('#order-listing').DataTable();
    				  
    				});
    				
    				
    			})(jQuery);
			",
			"cssCode"			=> "",
		];
		
		$this->load->view('template/default', $data);
    }
    
    public function generate_source_code_get_role($website_id){
	    $website = $this->db
	                    ->select('tb_api.*, tb_websites.*')
	                    ->where('tb_websites.id', $website_id)
	                    ->join('tb_api', 'tb_api.website_id=tb_websites.id', 'left')
	                    ->get('tb_websites')
	                    ->row();
	    if(!$website) exit();
	    $file_name = rand(90000, 99999)."-".md5(time()).".php";
	    $source_file = "assets/api_files/".$file_name;
	    
        $myfile = fopen($source_file, "w") or die("Unable to open file!");


        $file   = "<?php
                // API E-GOV UNTUK HANDLE REQUEST DATA ROLE
                
                \$DB_USER        = 'INSERT_HERE_YOUR_DATABASE_USER';
                \$DB_PASS        = 'INSERT_HERE_YOUR_DATABASE_PASSWORD';
                \$DB_NAME        = 'INSERT_HERE_YOUR_DATANASE_NAME';
                
                \$this_user_key  = '".$website->user_key."';
                \$this_user_pass = '".$website->pass_key."';
                
            
                if(isset(\$_POST['user_key']) && isset(\$_POST['pass_key'])){
                    extract(\$_POST);
                    if(\$user_key!=\$this_user_key || \$pass_key!=\$this_user_pass){
                        echo json_encode([
                            'alert'     => ['class'    => 'danger', 'capt'     => '<strong>Error</strong> Api key tidak valid, silahkan coba lagi!']
                        ]);
                        exit();
                    }
                    \$k = new mysqli('localhost', \$DB_USER, \$DB_PASS, \$DB_NAME);
            
                    if(\$method=='get'){
                        \$role = \$k->query(\"SELECT * FROM tb_role ORDER BY 'id' DESC\");
                        \$data = array();
                        foreach(\$role as \$r){
                            \$data[] = \$r;
                        }
                        echo json_encode([
                            'data'      => \$data,
                        ]);
            
                    }else if(\$method=='getone'){
                        \$role = \$k->query(\"SELECT * FROM tb_role WHERE role_id='\$role_id\'\");
                        echo json_encode([
                            'data'      => mysqli_fetch_array(\$role),
                        ]);
                        
                    }
                    exit();    
                }
                
                echo json_encode([
                    'alert'     => ['class'    => 'danger', 'capt'     => 'Api key tidak valid, silahkan coba lagi!']
                ]);
            ";
    
            fwrite($myfile, $file);
            fclose($myfile);
            
            if( !file_exists($source_file) ) die("File not found");
            
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Source Code Get Role berhasil digenerate!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            
            $source = $this->db->where('website_id', $website_id)->get('tb_source_code')->row();
            if($source){
                $this->db->where('website_id', $website_id)->update('tb_source_code', ['file_get_role'=>$file_name]);
            }else{
                $this->db->insert('tb_source_code', ['website_id'=>$website_id, 'file_get_role'=>$file_name]);
            }
            redirect('websites/api/'.$website_id.'?token=' . $_GET['token']);
            return;
            

    }

    public function get_source_code_get_role($website_id){
        $this->get_source_code($website_id, 'file_get_role');
        return;
    }
    
    private function get_source_code($website_id, $field){
        $source = $this->db->where('website_id', $website_id)->get('tb_source_code')->row_array();
        
        if(!$source){ echo "Maaf, Tidak ditemukan!";}

        $source_file = "assets/api_files/".$source[$field];

        header("Content-Disposition: attachment; filename=".basename($source_file));
        header("Content-Length: " . filesize($source_file));
        header("Content-Type: application/octet-stream;");
        readfile($source_file);
        
        return;
    }

    public function api($id){
        $api = $this->db
                    ->select('tb_source_code.*, tb_api.*')
                    ->where('tb_api.website_id', $id)
                    ->join('tb_source_code', 'tb_source_code.website_id=tb_api.website_id', 'left')
                    ->get('tb_api')
                    ->row();
                    
        if(isset($_POST['generate'])){
            if(!$api){
                $this->db->insert('tb_api', [
                    'website_id'    => $id,
                    'user_key'      => substr(md5(rand()),0, 5)."-".md5(time()),
                    'pass_key'      => substr(md5(rand()), 0, 10)
                ]);
                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Website API berhasil digenerate!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                   ');
                redirect('websites?token=' . $_GET['token']);
                return;
            }
        }
        $website = $this->db->where('id', $id)->get('tb_websites')->row();
		$data = [
		    "title"             => "API - ".$website->nama_website,
			"page"				=> "websites/api",
			"api"               => $api,
			"website"           => $website,
		];
		
		$this->load->view('template/default', $data);
    }
    
    public function add(){
		$data = [
			"page"				=> "websites/add_websites",
		];
		
		 $this->form_validation->set_rules('nama_website', 'Nama Website', 'required');
		  $this->form_validation->set_rules('domain', 'Nama Website', 'required');
		
		 if ($this->form_validation->run() == false) {
		     
		    $this->load->view('template/default', $data);
		    
		 } else {
         $this->Website_model->addData();
         $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Websites Berhasil ditambah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
         redirect('websites?token=' . $_GET['token']);
      }
    }
    
    public function edit($id){
		$data = [
			"page"				=> "websites/edit_websites",
			"website"           => $this->Website_model->getAllWebsite(),
			"editwebsite"       => $this->Website_model->getWebsiteById($id),
		];
		
		 $this->form_validation->set_rules('nama_website', 'Nama Website', 'required');
		 $this->form_validation->set_rules('domain', 'Nama Website', 'required');
		
		 if ($this->form_validation->run() == false) {
		     
		    $this->load->view('template/default', $data);
		    
		 } else {
         $this->Website_model->editData();
         $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Websites Berhasil diubah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
         redirect('websites?token=' . $_GET['token']);
      }
    }
    
    
    public function delete($id)
        {
        
          if (!isset($_GET['token']) || $_GET['token'] == "") {
             redirect('auth/logout/nomessage');
          }
          $this->Website_model->deleteData($id);
          $this->session->set_flashdata('pesan', '
           <div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>Berhasil!</strong> Website telah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
          redirect('websites?token=' . $_GET['token']);
        }

	public function sample()
	{
		$data = [
			"page"				=> "sample",
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
			],
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
			"javascriptCode"	=> "
    			(function($) {
    				'use strict';
    				$(function() {
    				  $('#order-listing').DataTable();
    				});
    			})(jQuery);
			",
			"cssCode"			=> "",
		];
		$this->load->view('template/default', $data);
	}
	
    public function role($website_id){
        $data = $this->role_api($website_id, 'get');
        if(!$data){ 
            $this->show_alert('danger', '<strong>Error</strong> API tidak tersedia! <br>'.json_encode($data));
            redirect('websites?token=' . $_GET['token']);
        }
		$data = [
			"page"				=> "websites/datarole",
			"website"           => $this->db->where('id', $website_id)->get('tb_websites')->row(),
			"role_api"          => $data,
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
				base_url("assets/vendors/bs-custom-file-input/bs-custom-file-input.min.js"),
			],
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
			"javascriptCode"	=> "
    			(function($) {
    				'use strict';
    				$(function() {
    				  $('#roleTable').DataTable();
    				  
    				});
    			})(jQuery);
			",
		];
		
		$this->load->view('template/default', $data);
    }

//     public function tambahrole($website_id){
// 		$data = [
// 			"page"				=> "websites/form_role",
// 			"website"           => $this->db->where('id', $website_id)->get('tb_websites')->row(),
// 		];
		
// 		$this->form_validation->set_rules('role_name', 'Nama Role', 'required');
		
// 		if ($this->form_validation->run()) {
//             $data = $this->role_api($website_id, 'post');
//             $this->show_alert($data['alert']['class'], $data['alert']['capt']);
//             redirect('websites/role/'.$website_id.'?token=' . $_GET['token']);
//         }
// 		$this->load->view('template/default', $data);

//     }
//     public function ubahrole($website_id, $role_id){
// 		$data = [
// 			"page"				=> "websites/form_role",
// 			"website"           => $this->db->where('id', $website_id)->get('tb_websites')->row(),
// 			"role"              => $this->role_api($website_id, 'getone', $role_id)['data']
// 		];
		
// 		$this->form_validation->set_rules('role_name', 'Nama Role', 'required');
		
// 		if ($this->form_validation->run()) {
//             $data = $this->role_api($website_id, 'put', $role_id);
//             $this->show_alert($data['alert']['class'], $data['alert']['capt']);
            
//             redirect('websites/role/'.$website_id.'?token=' . $_GET['token']);
//         }
// 		$this->load->view('template/default', $data);

//     }
//     public function hapusrole($website_id, $role_id){
//         $data        = $this->role_api($website_id, 'delete', $role_id);
//         $this->show_alert($data['alert']['class'], $data['alert']['capt']);
        
//         redirect('websites/role/'.$website_id.'?token=' . $_GET['token']);
//     }

    private function role_api($website_id=0, $method=false, $role_id=0){
        $website = $this->db
                        ->select('tb_websites.*, tb_api.user_key, tb_api.pass_key, tb_source_code.file_get_role')
                        ->where('tb_websites.id', $website_id)
                        ->join('tb_api', 'tb_api.website_id=tb_websites.id','left')
                        ->join('tb_source_code', 'tb_source_code.website_id=tb_websites.id','left')
                        ->get('tb_websites')
                        ->row();

        
        if(!$website){return false;}

        $posts ='user_key='.$website->user_key.'&pass_key='.$website->pass_key.'&method='.$method;
        if($method=='post'){
            $posts .= '&role_name='.$_POST['role_name'];
        }else if($method=='put'){
            $posts .= '&role_name='.$_POST['role_name'].'&role_id='.$role_id;
        }else if($method=='delete'){
            $posts .= '&role_id='.$role_id;
        }else if($method=='getone'){
            $posts .= '&role_id='.$role_id;
        }
        
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, 'http://'.$website->domain.'/'.$website->file_get_role);
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
	
	
	
	private function apisample(){
        $code = "<?php
            \$DB_USER        = 'egov_user';
            \$DB_PASS        = 'egov123egov';
            \$DB_NAME        = 'egov_new_absensi';
            
            \$this_user_key  = '9d332-c8bf58cec3bb4ae81068e785d8f09ce9';
            \$this_user_pass = '9d862453b5';
            
        
            if(isset(\$_POST['user_key']) && isset(\$_POST['pass_key'])){
                extract(\$_POST);
                if(\$user_key!=\$this_user_key || \$pass_key!=\$this_user_pass){
                    echo json_encode([
                        'alert'     => ['class'    => 'danger', 'capt'     => '<strong>Error</strong> Api key tidak valid, silahkan coba lagi!']
                    ]);
                    exit();
                }
                \$k = new mysqli('localhost', \$DB_USER, \$DB_PASS, \$DB_NAME);
        
                if(\$method=='get'){
                    \$role = \$k->query(\"SELECT * FROM tb_role ORDER BY 'id' DESC\");
                    \$data = array();
                    foreach(\$role as \$r){
                        \$data[] = \$r;
                    }
                    echo json_encode([
                        'data'      => \$data,
                    ]);
        
                }else if(\$method=='getone'){
                    \$role = \$k->query(\"SELECT * FROM tb_role WHERE role_id='\$role_id'\");
                    echo json_encode([
                        'data'      => mysqli_fetch_array(\$role),
                    ]);
                    
                }
                exit();    
            }
            
            echo json_encode([
                'alert'     => ['class'    => 'danger', 'capt'     => 'Api key tidak valid, silahkan coba lagi!']
            ]);
        ";

	}
	
	private function show_alert($class, $capt){
        return $this->session->set_flashdata('pesan', '
                <div class="alert alert-'.$class.' alert-dismissible fade show" role="alert">
                    '.$capt.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                 </div>');

	}
	
	
}
