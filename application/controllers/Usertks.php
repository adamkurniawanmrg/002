<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usertks extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
        $this->load->model(['Api_model','Opd_model','Pegawai_model','Pegawaitks_model']);
		is_logged_in();
    }
    
    public function getAllTks(){
	    $this->accessable([1,8]);

        extract($_POST);

        $no = 1;
        $data = array();
        $datatks = $this->Pegawaitks_model->getAllTks($skpd_id);
        foreach ($datatks as $dt) {
            $d[0]      = $no;$no++;
            $d[1]      = $dt->nama_tks;
            $d[2]      = $dt->nik;
            $d[3]      = '<span title="'.$dt->nama_skpd.'">'.(strlen($dt->nama_skpd) > 20 ? substr($dt->nama_skpd, 0,20)."..." : $dt->nama_skpd).'</td>';
            $d[4]      = $dt->no_hp;
            $d[5]      = ($this->session->userdata('role_id') == 1 ?
                        '
                        <a href="'.base_url('usertks/konfigurasirole/') . $dt->id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Konfigurasi Role" style="padding: 5px 9px"><em class="ti-exchange-vertical"></em></a>
                        <a href="'.base_url('usertks/pengaturanakun/') . $dt->id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Pengaturan Akun" style="padding: 5px 9px"><em class="ti-settings"></em></a>
                        ' : null).
                        '<a href="'.base_url('usertks/setpegawaiatasan/') . $dt->id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Set Pegawai Atasan" style="padding: 5px 9px"><em class="ti-user"></em></a>'.
                        ' <a href="'.base_url('usertks/edit/' . $dt->id . '?token=' . $_GET['token']).'" class="btn btn-warning btn-sm" title="Ubah" style="padding: 5px 9px"><em class="ti-pencil-alt"></em></a>
                        '.($this->session->userdata('role_id')==1 ? '<a href="'.base_url('usertks/delete/' . $dt->id . '?token=' . $_GET['token']).'" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Anda yakin hapus ?\')" title="Hapus" style="padding: 5px 9px"><em class="ti-trash"></em></a>':null);
        
            $data[] = $d;
        }
        
        echo json_encode(["data"=>$data]);
        return;

    }

    public function index(){
	    $this->accessable([1,8]);

        
		$SIMPEG      = $this->load->database('otherdb', TRUE);
        $skpds       = $SIMPEG->get('skpd')->result_array();
        
		$data = [
			"page"				=> "usertks/data_pegawaitks",
			"title"             => "Data TKS",
			"skpds"             => $skpds,
			"skpds2"            => $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result_array(),
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
		];

// 		$data['dataopd'] = array();
//         foreach ($this->Opd_model->getAllOpd() as $opd) {
//             $this->db->where('opd_id', $opd['id']);
//             $this->db->where('kategori_pegawai', "pegawai");
//             $pegawai_tetap = $this->Pegawai_model->getAllPegawai();

//             $this->db->where('opd_id', $opd['id']);
//             $this->db->where('kepala', 1);
//             $kepala = $this->Pegawai_model->getPegawai();
//             $data_opd = array([
//                 'id'                => $opd['id'],
//                 'nama_opd'          => $opd['nama_opd'],
//                 'singkatan'         => $opd['singkatan'],
//                 'nama_kepala'       => $kepala['nama'],
//                 'jumlah_pegawai'    => count($pegawai_tetap)
//             ]);

//             array_push($data['dataopd'], $data_opd);
//         }

		$this->load->view('template/default', $data);
    }
    
      public function tambah(){
	    $this->accessable([1,8]);

		$SIMPEG      = $this->load->database('otherdb', TRUE);

        if($this->session->userdata('role_id')!=1){
            $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
            if(count($unitkerjas)>0){
                foreach($unitkerjas as $unitkerja){
                    $SIMPEG->or_where('id_skpd', $unitkerja->skpd_id);                
                }
            }else{
                $SIMPEG->where('id_skpd', $this->session->userdata('skpd_id'));                
            }
        }

        $skpds       = $SIMPEG->get('skpd')->result();
        
		$data = [
			"page"				=> "usertks/tambah_pegawaitks",
			"title"             => "Tambah Data Pegawai TKS",
			"skpsd"             => $skpds,
		];
		
		
		 $this->form_validation->set_rules('nama_tks', 'Nama Pegawai Tks', 'required');
		 $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[16]|max_length[16]');
         $this->form_validation->set_rules('skpd_id', 'Unit Kerja', 'required');
         $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');

		 if ($this->form_validation->run() == false) {
		    $this->load->view('template/default', $data);
		 } else {
		    if($tksExists = $SIMPEG->where('nik', $_POST['nik'])->get('tb_pegawai_tks')->row()){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Menambah Data Pegawai TKS !</strong> NIK sudah ada, mohon periksa kembali!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
             redirect('usertks/tambah?token=' . $_GET['token']);
		        
		    }
		    $metas      = $this->db->where('no_hp', $_POST['no_hp'])->get('tb_pegawai_meta')->num_rows();

            if($metas>0){
                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nomor telepon sudah digunakan akun lain!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                   ');
                redirect('usertks?token=' . $_GET['token']);
                return;
            }

             $this->Pegawaitks_model->addDataTKs();
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil !</strong> Data Pegawai TKS Berhasil di Tambah
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
             redirect('usertks?token=' . $_GET['token']);
      }
    }
    
    public function edit($id){
	    $this->accessable([1,8]);

      	$SIMPEG      = $this->load->database('otherdb', TRUE);
        if($this->session->userdata('role_id')!=1){
            $datatks = $SIMPEG->where('id', $id)->get('tb_pegawai_tks')->row();
            $skpdsUJ = array();
            $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
            foreach($unitkerjas as $uj){
                $skpdsUJ[] = $uj->skpd_id;
            }
            $skpdsUJ[] = $this->session->userdata('skpd_id');
            if(!$datatks || !in_array($datatks->skpd_id, $skpdsUJ)){
                redirect('usertks?token=' . $_GET['token']);
            }
        }

        if($this->session->userdata('role_id')!=1){
            $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
            if(count($unitkerjas)>0){
                foreach($unitkerjas as $unitkerja){
                    $SIMPEG->or_where('id_skpd', $unitkerja->skpd_id);                
                }
            }else{
                $SIMPEG->where('id_skpd', $this->session->userdata('skpd_id'));                
            }
        }

        $skpds       = $SIMPEG->get('skpd')->result();
        
		$data = [
			"page"				=> "usertks/ubah_pegawaitks",
			"title"             => "Ubah Data Pegawai TKS",
			"skpsd"             => $skpds,
			"edittks"           => $this->Pegawaitks_model->getTksById($id),
			"javascript"		=> [
			
				base_url("assets/js/file-upload.js"),
				
				base_url("assets/js/select2.js"),
			],
			"css"				=> [
			
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
		
		 $this->form_validation->set_rules('nama_tks', 'Nama Pegawai Tks', 'required');
		 $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[16]|max_length[20]');
         $this->form_validation->set_rules('skpd_id', 'Unit Kerja', 'required');
         $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');
		
		if($this->form_validation->run() == false) {
		    $this->load->view('template/default', $data);
		} else {
		    $metas      = $this->db->where('no_hp', $_POST['no_hp'])->get('tb_pegawai_meta')->result_array();
		    foreach($metas as $meta){
	            if($meta['pegawai_id']."-".$meta['jenis_pegawai']!=$id."-tks"){
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Nomor telepon sudah digunakan akun lain!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                       ');
                    redirect('usertks?token=' . $_GET['token']);
                    return;
	            }
		    }
            $this->Pegawaitks_model->editDataTks($id);
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data Pegawai Tks berhasil diubah
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
             redirect('usertks?token=' . $_GET['token']);
        }
    }
    
    public function setpegawaiatasan($id){
	    $this->accessable([1,8]);

      	$SIMPEG         = $this->load->database('otherdb', TRUE);
        $datatks        = $SIMPEG->where('id', $id)->get('tb_pegawai_tks')->row();
        if(!$datatks){
            redirect('usertks?token=' . $_GET['token']);
        }

		$pegawai_atasan = $this->db->where('pegawai_id', $id)
		                                ->where('jenis_pegawai', 'tks')
		                                ->get('tb_pegawai_atasan')
		                                ->row();

        if($this->session->userdata('role_id')!=1){
            $skpdsUJ = array();
            $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
            foreach($unitkerjas as $uj){
                $skpdsUJ[] = $uj->skpd_id;
            }
            $skpdsUJ[] = $this->session->userdata('skpd_id');
            if(!$datatks || !in_array($datatks->skpd_id, $skpdsUJ)){
                redirect('usertks?token=' . $_GET['token']);
            }
        }
        $skpds      = $SIMPEG->get('skpd')->result();

		$this->form_validation->set_rules('skpd_atasan_id', 'Unit Kerja Atasan', 'required');
		$this->form_validation->set_rules('pegawai_atasan_id', 'Pegawai Atasan', 'required');

		if($this->form_validation->run()){
		    $post_pegawai_atasan = explode("-_-", $_POST['pegawai_atasan_id']);
            $data = [
		            "pegawai_id"             => $id,
		            "jenis_pegawai"          => 'tks',
		            "nama_pegawai"           => $datatks->nama_tks,
		            "skpd_id"                => $this->session->userdata('skpd_id'),
		            "pegawai_atasan_id"      => $post_pegawai_atasan[0],
		            "jenis_pegawai_atasan"   => $post_pegawai_atasan[1],
		            "nama_pegawai_atasan"    => $post_pegawai_atasan[2],
		            "skpd_atasan_id"         => $_POST['skpd_atasan_id'],
		            "set_by_pegawai_id"      => $this->session->userdata('user_id'),
		            "set_by_jenis_pegawai"   => $this->session->userdata('jenis_pegawai'),
		            "set_by_nama_pegawai"    => $this->session->userdata('nama'),
		            "updated_at"             => date("Y-m-d H:i:s")
                ];
            if($pegawai_atasan){
                $this->db->where('pegawai_id', $id)->where('jenis_pegawai', 'tks')->update('tb_pegawai_atasan', $data);
            }else{
                $this->db->insert('tb_pegawai_atasan', $data);
            }

            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                Pegawai atasan berhasil di set!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
             redirect('usertks/setpegawaiatasan/'.$id.'?token=' . $_GET['token']);
             return;
        }


		$this->load->view('template/default', [
			"title"             => "Set Pegawai Atasan - ".$datatks->nama_tks,
			"page"				=> "usertks/setpegawaiatasan",
			"skpsd"             => $skpds,
			"gskpd"             => $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result_array(),
			"datatks"           => $datatks,
			"pegawai_atasan"    => $pegawai_atasan,
		]);
		return;
    }

    public function selectOptionPegawaiAtasan(){
        if(isset($_POST['skpd_id']) && $_POST['skpd_id']){
            $SIMPEG      = $this->load->database('otherdb', TRUE);
            $pegawai   = $SIMPEG
                            ->where('pegawai.id_skpd', $_POST['skpd_id'])
                            ->where('pegawai.status_pegawai', 'pegawai')
                            ->where('pegawai.nama_pegawai!=','')
                            ->where('pegawai.nip!=','')
                            ->where('pegawai.nama_pegawai is NOT NULL')
                            ->where('pegawai.nip is NOT NULL')
                            ->order_by('nama_pegawai', 'asc')
                            ->get('pegawai')
                            ->result_array();
            if($pegawai && count($pegawai)>0){
                echo "<option value=''>-- Pilih Pegawai Atasan --</option>";
                foreach ($pegawai as $p) {
                    $nama = ($p['gelar_depan'] && $p['gelar_depan']!="" ? $p['gelar_depan'].". " : null).$p['nama_pegawai'].($p['gelar_belakang'] && $p['gelar_belakang']!="" ? ", ".$p['gelar_belakang'] : null);
                    echo "<option value='" . $p['id_pegawai'].'-_-pegawai-_-'.$nama . "'>" . $nama . "</option>";
                }
                return;
            }
        }elseif(isset($_POST['skpd_id'])){
            echo "<option value=''>-- Pilih Pegawai Atasan --</option>";
            return;

        }
        echo "<option value=''>-- Tidak ada data --</option>";
        return;
    }

    
    public function delete($id)
    {
	    $this->accessable([1]);

      if (!isset($_GET['token']) || $_GET['token'] == "") {
         redirect('auth/logout/nomessage');
      }
      $this->Pegawaitks_model->deleteDataTks($id);
      $this->session->set_flashdata('pesan', '
       <div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Berhasil !</strong>Data Pegawai TKS telah di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       ');
      redirect('usertks?token=' . $_GET['token']);
    }



    public function konfigurasirole($user_id=false){
	    $this->accessable([1]);

        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $pegawai     = $SIMPEG->select('tb_pegawai_tks.*')->where('id', $user_id)->get('tb_pegawai_tks')->row();
        
        if(!$pegawai){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf</strong> User tidak ditemukan !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('user?token=' . $_GET['token']);
            return;
        }
        
		$data = [
		    "title"             => "Konfigurasi Role Pengguna - ".$pegawai->nama_tks,
		    "websites"          => $this->db->select('tb_websites.*, tb_api.id api_id')
		                                    ->join('tb_api','tb_api.website_id=tb_websites.id','left')
		                                    ->order_by('tb_websites.nama_website', 'asc')
		                                    ->get('tb_websites')
		                                    ->result(),
		    "user"              => $pegawai,
			"page"				=> "usertks/konfigurasirole",
				"javascript"		=> [
			],
			"css"				=> [
			],
			"javascriptCode"	=> "",
			"cssCode"			=> "",
		];
		

		 if(!isset($_POST['role_in'])) {
		    $this->load->view('template/default', $data);		    
		 } else {
            $this->db
                ->where('user_id', $user_id)
                ->where('jenis_pegawai', 'tks')
                ->delete('tb_user_roled_website');
            foreach($_POST['role_in'] as $website_id=>$role_id):
                if($role_id == 0) continue;
                $this->db->insert('tb_user_roled_website', [
                        "user_id"       => $user_id,
                        "role_id"       => $role_id,
                        "jenis_pegawai" => 'tks',
                        "website_id"    => $website_id
                    ]);
            endforeach;
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Akses role user berhasil di perbaharui !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
             redirect('usertks?token=' . $_GET['token']);
      }
    }
    
      public function generaterole(){
	    $this->accessable([1]);

        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $opd         = $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result();
        $websites    = $this->db->order_by('nama_website', 'asc')->get('tb_websites')->result();

		$data = [
		    "title"             => "Generate Role TKS",
			"page"				=> "usertks/generaterole",
			"opds"              => $opd,
			"websites"          => $websites,
		];

		$this->form_validation->set_rules('opd_id', 'OPD', 'required');
		$this->form_validation->set_rules('website_id', 'Website', 'required');
		$this->form_validation->set_rules('role', 'Role', 'required');
		
		if ($this->form_validation->run() == false) {
		    $this->load->view('template/default', $data);
		    
        }else {
            extract($_POST);
            
            if($opd_id==0) {
                $this->generateAll($website_id, $role);
                return;
            }
            
            $values = "INSERT INTO tb_user_roled_website (website_id, user_id, role_id, jenis_pegawai)VALUES";
            $first = true;
            $num = 0;
            foreach($pegawai as $key=>$pegawai){
                if($action == 'skip'){
                    $cek_exists = $this->db
                                        ->where('website_id', $website_id)
                                        ->where('user_id', $pegawai)
                                        ->get('tb_user_roled_website')
                                        ->num_rows();
                    if($cek_exists>0) continue;
                }
                $this->db
                        ->where('website_id', $website_id)
                        ->where('user_id', $pegawai)
                        ->delete('tb_user_roled_website');
                
                if($role==0) continue;

                if(!$first) $values .= ",";
                $values .= "($website_id, $pegawai, $role, 'tks')";
                $first = false;
                $num++;
            }
            
            if($num>0) $this->db->query($values);
            
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data OPD berhasil digenerate!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('usertks/generaterole?token=' . $_GET['token']);
        }
    }

    private function generateAll($website_id, $role){
                $SIMPEG     = $this->load->database('otherdb', TRUE);
                $pegawais   = $SIMPEG->select('
                                            tb_pegawai_tks.id user_id, 
                                        ')
                                ->get('tb_pegawai_tks')
                                ->result();

                $this->db
                        ->where('website_id', $website_id)
                        ->where('jenis_pegawai', 'tks')
                        ->delete('tb_user_roled_website');
    
                $values = "INSERT INTO tb_user_roled_website (website_id, user_id, role_id, jenis_pegawai)VALUES";
                $first  = true;
                $num    = 0;

                if($role!=0){
                    foreach($pegawais as $pegawai){
                        if(!$first) $values .= ",";
                        $values     .= "($website_id, $pegawai->user_id, $role, 'tks')";
                        $first       = false;
                        $num++;
                    }
    
                    if($num>0) $this->db->query($values);
                }

                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data OPD berhasil digenerate!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
                redirect('usertks/generaterole?token=' . $_GET['token']);
                return;
    }

    public function getpegawaibyskpd(){

        if(isset($_POST['opd_id'])){
            $SIMPEG      = $this->load->database('otherdb', TRUE);
            $pegawai     = $SIMPEG->select('tb_pegawai_tks.id, tb_pegawai_tks.nama_tks nama, tb_pegawai_tks.nik nip')
                                    ->where('skpd_id', $_POST['opd_id'])
                                    ->get('tb_pegawai_tks')
                                    ->result();
            $opd         = $SIMPEG->where('id_skpd', $_POST['opd_id'])->get('skpd')->row();
            echo json_encode(["pegawai"=>$pegawai, "opd"=>$opd]);
    
        }        
    }

    public function getrole_generaterole(){
	    $this->accessable([1]);
        if(isset($_POST['website_id'])){
            $website = $this->db->where('id', $_POST['website_id'])->get('tb_websites')->row();
            if(!$website){echo "Tidak tersambung";return;}
            
            if($website->jenis_auth=="default"):
                $roles = $this->db->where('website_id', $website->id)->get('tb_role')->result();

                if(count($roles)==0){echo "Tidak ada Role";return;}

                $roled = "";
                    $roled.="<label style='margin-right: 5px;'><input type='radio' name='role' value='0' checked> Tidak ada akses</label>";                    
                foreach($roles as $role){
                    $roled.="<label style='margin-right: 5px;'><input type='radio' name='role' value='".$role->role_id."'> ".$role->role_name."</label>";                    
                }
            else:
                $this->load->model('Api_model');
                $roles = $this->Api_model->role_api($website->id, 'get');
    
                if(!$roles){echo "Tidak tersambung";return;}
    
                $roled = "";
                    $roled.="<label style='margin-right: 5px;'><input type='radio' name='role' value='0' checked> Tidak ada akses</label>";                    
                foreach($roles['data'] as $role){
                    $roled.="<label style='margin-right: 5px;'><input type='radio' name='role' value='".$role['role_id']."'> ".$role['role_name']."</label>";                    
                }
            endif;
            
            echo $roled;
            return;
        }
        echo "Tidak tersambung";
        return;
    }

   
	public function pengaturanakun($user_id)
	{
	    $this->accessable([1]);
        $this->form_validation->set_rules('no_hp', 'No WhatsApp', 'required');

        $SIMPEG         = $this->load->database('otherdb', TRUE);
        $pegawai        = $SIMPEG->where('id', $user_id)->get('tb_pegawai_tks')->row();
        
        if(!$pegawai){
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> TKS tidak ditemukan !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('usertks?token=' . $_GET['token']);
        }


        $pegawaiMeta            = $this->db->
                                         where('pegawai_id', $user_id)->
                                         where('jenis_pegawai', 'tks')->
                                         get('tb_pegawai_meta')->
                                         row();


        if($this->form_validation->run()) {
            $datametanohp   =  $this->db->
                                      where('no_hp', $_POST['no_hp'])->
                                      get('tb_pegawai_meta')->row();

            $nomor_whatsapp_saya    = isset($pegawaiMeta->no_hp) ? $pegawaiMeta->no_hp : $pegawai->no_hp;
            if($nomor_whatsapp_saya!=$_POST['no_hp'] && $datametanohp){
	            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Nomor Whatsapp/Handphone sudah digunakan!</div>');
	            redirect('usertks/pengaturanakun/'.$user_id.'?token='.$_GET['token']);
	            return;
            }

            $data = [
                    'password'      => $_POST['password_baru']!= null ? password_hash($_POST['password_baru'], PASSWORD_DEFAULT) : 
                                        (isset($pegawaiMeta->password) ? $pegawaiMeta->password : $pegawai->password),
                    'no_hp'         => $_POST['no_hp'],
                    'nip'           => $pegawai->nik,
                    'pegawai_id'    => $user_id,
                    'jenis_pegawai' => 'tks',
                ];
        
            if($pegawaiMeta){
                $this->db->where('id', $pegawaiMeta->id)->update('tb_pegawai_meta', $data);
            }else{
                $this->db->insert('tb_pegawai_meta', $data);
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Profil berhasil diubah.</div>');
            redirect('usertks/pengaturanakun/'.$user_id.'?token='.$_GET['token']);
            return;
        }

		$this->load->view('template/default', [
		    "title"             => "Pengaturan Akun / Ubah Akun : ".(isset($pegawaiMeta->nama) ? $pegawaiMeta->nama : $pegawai->nama_tks),
			"page"				=> "pengaturanakun",
			"no_hp"             => isset($pegawaiMeta->no_hp) ? $pegawaiMeta->no_hp : $pegawai->no_hp,
			"is_admin"          => true
		]);
        return;
    }
    private function accessable($roles){
        if(!in_array($this->session->userdata('role_id'), $roles)){
            redirect('home?token='.$_GET['token']);
            exit();
        }
    }

}
