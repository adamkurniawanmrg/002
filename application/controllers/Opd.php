<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opd extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
        $this->load->model(['Opd_model','Pegawai_model']);
		is_logged_in();
    }

    public function index(){
		$data = [
			"page"				=> "opd/data_opd",
			"title"             => "Data OPD",
// 			"dataopd"           => $this->db->get('tb_opd')->result(),
			
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
		
		$data['dataopd'] = array();
        foreach ($this->Opd_model->getAllOpd() as $opd) {
            $pegawai_tetap = $this->db->where('opd_id', $opd['id'])->where('kategori_pegawai', "pegawai")->get('tb_pegawai')->num_rows;

            $this->db->where('opd_id', $opd['id']);
            $this->db->where('kepala', 1);
            $kepala = $this->Pegawai_model->getPegawai();
            $data_opd = array([
                'id'                => $opd['id'],
                'nama_opd'          => $opd['nama_opd'],
                'singkatan'         => $opd['singkatan'],
                'nama_kepala'       => $kepala['nama'],
                'jumlah_pegawai'    => $pegawai_tetap
            ]);

            array_push($data['dataopd'], $data_opd);
        }
		
		$this->load->view('template/default', $data);
    }
    
      public function addopd(){
		$data = [
			"page"				=> "opd/add_opd",
		];
		
		 $this->form_validation->set_rules('nama_opd', 'Nama OPD', 'required');
		  $this->form_validation->set_rules('singkatan', 'Singkatan', 'required');
		
		 if ($this->form_validation->run() == false) {
		     
		    $this->load->view('template/default', $data);
		    
		 } else {
         $this->Opd_model->addDataOpd();
         $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Data OPD Berhasil di Tambah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
         redirect('opd?token=' . $_GET['token']);
      }
    }
    
      public function editopd($id){
		$data = [
			"page"				=> "opd/edit_opd",
			"dataopd"           => $this->Opd_model->getAllOpd(),
			"editopd"       => $this->Opd_model->getOpdById($id),
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
		
		 $this->form_validation->set_rules('nama_opd', 'Nama OPD', 'required');
		 $this->form_validation->set_rules('singkatan', 'Nama Website', 'required');
		
		 if ($this->form_validation->run() == false) {
		    $this->load->view('template/default', $data);
		    
		 } else {
         $this->Opd_model->editDataOpd();
         $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data OPD berhasil diubah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
         redirect('opd?token=' . $_GET['token']);
      }
    }
    
    
    public function deleteopd($id)
    {
    
      if (!isset($_GET['token']) || $_GET['token'] == "") {
         redirect('auth/logout/nomessage');
      }
      $this->Opd_model->deleteDataOpd($id);
      $this->session->set_flashdata('pesan', '
       <div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Berhasil !</strong>Data Opd telah di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       ');
      redirect('opd?token=' . $_GET['token']);
    }


    
}
