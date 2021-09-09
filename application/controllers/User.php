<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(['User_model', 'Api_model']);
		date_default_timezone_set("Asia/Jakarta");
		is_logged_in();
    }
    public function getAllUsers(){
	    $this->accessable([1,8]);

        extract($_POST);

        $data = array();
        $no = 1;

        $users = $this->User_model->getAllUser($skpd_id);
        
        // $datametanohp   =  $this->db->
                                   
        //                               where('pegawai_id', $u->pegawai_id)->
        //                               where('nip', $u->nip)->
        //                               get('tb_pegawai_meta')->row();
        foreach ($users as $u) {

       
                                  
            $dt[0] = $no;$no++;
            $dt[1] = ($u->gelar_depan && $u->gelar_depan!="" ? $u->gelar_depan.". " : null).$u->nama_pegawai.($u->gelar_belakang && $u->gelar_belakang!="" ? ", ".$u->gelar_belakang : null);
            $dt[2] = '<span title="'.$u->nama_skpd.'">'.(strlen($u->nama_skpd) > 30 ? substr($u->nama_skpd, 0, 30)."..." : $u->nama_skpd).'</td>';
            $dt[3] = '<td>'.$u->nip.'</td>';
            // $dt[4] = '<td>'.(isset($datametanohp->no_hp) ? $datametanohp->no_hp : null).'</td>';
            $dt[4] = ($this->session->userdata('role_id') == 1 ?
                        '<a href="'.base_url('user/konfigurasirole/') . $u->pegawai_id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Konfigurasi Role" style="padding: 5px 9px"><em class="ti-exchange-vertical"></em></a>
                        <a href="'.base_url('user/pengaturanakun/') . $u->pegawai_id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Pengaturan Akun" style="padding: 5px 9px"><em class="ti-settings"></em></a>' : null).
                        ' <a href="'.base_url('user/setpegawaiatasan/') . $u->pegawai_id . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" title="Set Pegawai Atasan" style="padding: 5px 9px"><em class="ti-user"></em></a>';
            $data[] = $dt;
        }
        
        
        echo json_encode(["data"=> $data]);
        return;


    }
    public function index(){
	    $this->accessable([1,8]);

        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $akses = [1];
        $is_akses = in_array($this->session->userdata('role_id'), $akses);
        if(!$is_akses){
            $SIMPEG->where('id_skpd', $this->session->userdata('skpd_id'));
        }
        $skpds       = $SIMPEG->get('skpd')->result_array();

		$data = [
		    "title"             => "Data PNS",
			"page"				=> "user/data_user",
			"skpds"             => $skpds,
			"skpds2"            => $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result_array(),
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
				$this->session->userdata('role_id')!=1 ? null : "https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js",
				$this->session->userdata('role_id')!=1 ? null : "https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js",

			],
			"css"               =>[
                base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"), 
                $this->session->userdata('role_id')!=1 ? null : "https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"
			],
		];
		
		$this->load->view('template/default', $data);
    }
    
    public function setpegawaiatasan($id){
	    $this->accessable([1,8]);

      	$SIMPEG         = $this->load->database('otherdb', TRUE);
        $data           = $SIMPEG->where('id_pegawai', $id)->get('pegawai')->row();
        $nama           = ($data->gelar_depan && $data->gelar_depan!="" ? $data->gelar_depan.". " : null).$data->nama_pegawai.($data->gelar_belakang && $data->gelar_belakang!="" ? ", ".$data->gelar_belakang : null);
        if(!$data){
            redirect('user?token=' . $_GET['token']);
        }

		$pegawai_atasan = $this->db->where('pegawai_id', $id)
		                                ->where('jenis_pegawai', 'pegawai')
		                                ->get('tb_pegawai_atasan')
		                                ->row();

        if($this->session->userdata('role_id')!=1){
            $skpdsUJ = array();
            $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
            foreach($unitkerjas as $uj){
                $skpdsUJ[] = $uj->skpd_id;
            }
            $skpdsUJ[] = $this->session->userdata('skpd_id');
            if(!$data || !in_array($data->id_skpd, $skpdsUJ)){
                redirect('user?token=' . $_GET['token']);
            }
        }
        $skpds      = $SIMPEG->get('skpd')->result();

		$this->form_validation->set_rules('skpd_atasan_id', 'Unit Kerja Atasan', 'required');
		$this->form_validation->set_rules('pegawai_atasan_id', 'Pegawai Atasan', 'required');

		if($this->form_validation->run()){
		    $post_pegawai_atasan = explode("-_-", $_POST['pegawai_atasan_id']);
            $data = [
		            "pegawai_id"             => $id,
		            "jenis_pegawai"          => 'pegawai',
		            "nama_pegawai"           => $nama,
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
                $this->db->where('pegawai_id', $id)->where('jenis_pegawai', 'pegawai')->update('tb_pegawai_atasan', $data);
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
             redirect('user/setpegawaiatasan/'.$id.'?token=' . $_GET['token']);
             return;
        }

		$this->load->view('template/default', [
			"title"             => "Set Pegawai Atasan - ".$nama,
			"page"				=> "user/setpegawaiatasan",
			"skpsd"             => $skpds,
			"gskpd"             => $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result_array(),
			"data"              => $data,
			"pegawai_atasan"    => $pegawai_atasan,
		]);
		return;
    }
    
    public function selectOptionPegawaiAtasan(){
	    $this->accessable([1,8]);

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

    
    
    public function generaterole(){
	    $this->accessable([1]);

        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $opd         = $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result();
        $websites    = $this->db->order_by('nama_website', 'asc')->get('tb_websites')->result();

		$data = [
		    "title"             => "Generate Role",
			"page"				=> "user/generaterole",
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
            
            $values = "INSERT INTO tb_user_roled_website (website_id, user_id, role_id)VALUES";
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
                $values .= "($website_id, $pegawai, $role)";
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
            redirect('user/generaterole?token=' . $_GET['token']);
        }
    }

    private function generateAll($website_id, $role){

                $SIMPEG      = $this->load->database('otherdb', TRUE);
                $pegawai       = $SIMPEG->select('pegawai.id_pegawai pegawai_id')
                                        ->where('status_pegawai', 'pegawai')
                                        ->where('nama_pegawai!=','')
                                        ->where('nip!=','')
                                        ->where('nama_pegawai is NOT NULL')
                                        ->where('nip is NOT NULL')
                                        ->get('pegawai')->result();
                $this->db
                        ->where('website_id', $website_id)
                        ->where('jenis_pegawai', 'pegawai')
                        ->delete('tb_user_roled_website');
    
                $values = "INSERT INTO tb_user_roled_website (website_id, user_id, role_id)VALUES";
                $first  = true;
                $num    = 0;

                if($role!=0){
                    foreach($pegawai as $key=>$pegawai){
                        if(!$first) $values .= ",";
                        $values .= "($website_id, $pegawai->pegawai_id, $role)";
                        $first   = false;
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
                  </div>
                   ');
                redirect('user/generaterole?token=' . $_GET['token']);
                return;
    }

    public function getpegawaibyskpd(){
        if(isset($_POST['opd_id'])){
            $SIMPEG      = $this->load->database('otherdb', TRUE);
            $pegawai     = $SIMPEG->select('pegawai.id_pegawai id, pegawai.nama_pegawai nama, pegawai.nip')
                                    ->where('id_skpd', $_POST['opd_id'])
                                    ->get('pegawai')
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

    public function konfigurasirole($user_id=false){
	    $this->accessable([1]);

        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $pegawai     = $SIMPEG->select('pegawai.*, pegawai.id_pegawai id')->where('id_pegawai', $user_id)->get('pegawai')->row();
        
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
		    "title"             => "Konfigurasi Role Pengguna - ".$pegawai->nama_pegawai,
		    "websites"          => $this->db->select('tb_websites.*, tb_api.id api_id')
		                                    ->join('tb_api','tb_api.website_id=tb_websites.id','left')
		                                    ->order_by('tb_websites.nama_website', 'asc')
		                                    ->get('tb_websites')
		                                    ->result(),
		    "user"              => $pegawai,
			"page"				=> "user/konfigurasirole",
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
                ->where('jenis_pegawai', 'pegawai')
                ->delete('tb_user_roled_website');
            foreach($_POST['role_in'] as $website_id=>$role_id):
                if($role_id == 0) continue;
                $this->db->insert('tb_user_roled_website', [
                        "user_id"       => $user_id,
                        "role_id"       => $role_id,
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
             redirect('user?token=' . $_GET['token']);
      }
    }
    
	public function pengaturanakun($user_id)
	{
	    $this->accessable([1]);
        $this->form_validation->set_rules('no_hp', 'No WhatsApp', 'required');

        $SIMPEG         = $this->load->database('otherdb', TRUE);
        $pegawai        = $SIMPEG->where('id_pegawai', $user_id)->get('pegawai')->row();
        
        if(!$pegawai){
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Pegawai tidak ditemukan !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('user?token=' . $_GET['token']);
        }

        $gelarDepan             = $pegawai->gelar_depan && $pegawai->gelar_depan!="" ? $pegawai->gelar_depan.". " : null;
        $gelarBelakang          = $pegawai->gelar_belakang && $pegawai->gelar_belakang!="" ? ", ".$pegawai->gelar_belakang : null;
        $pegawai->nama_pegawai  = $gelarDepan.$pegawai->nama_pegawai.$gelarBelakang;

        $pegawaiMeta            = $this->db->
                                         where('pegawai_id', $user_id)->
                                         where('jenis_pegawai', 'pegawai')->
                                         get('tb_pegawai_meta')->
                                         row();


        if ($this->form_validation->run()) {
            $datametanohp   =  $this->db->
                                      where('no_hp', $_POST['no_hp'])->
                                      get('tb_pegawai_meta')->row();

            $nomor_whatsapp_saya    = isset($pegawaiMeta->no_hp) ? $pegawaiMeta->no_hp : $pegawai->no_hp;
            if($nomor_whatsapp_saya!=$_POST['no_hp'] && $datametanohp){
	            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Nomor Whatsapp/Handphone sudah digunakan!</div>');
	            redirect('user/pengaturanakun/'.$user_id.'?token='.$_GET['token']);
	            return;
            }

            $data = [
                    'password'      => $_POST['password_baru']!= null ? password_hash($_POST['password_baru'], PASSWORD_DEFAULT) : 
                                        (isset($pegawaiMeta->password) ? $pegawaiMeta->password : $pegawai->password),
                    'no_hp'         => $_POST['no_hp'],
                    'nip'           => $pegawai->nip,
                    'pegawai_id'    => $user_id,
                    'jenis_pegawai' => 'pegawai',
                ];
        
            if($pegawaiMeta){
                $this->db->where('id', $pegawaiMeta->id)->update('tb_pegawai_meta', $data);
            }else{
                $this->db->insert('tb_pegawai_meta', $data);
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Profil berhasil diubah.</div>');
            redirect('user/pengaturanakun/'.$user_id.'?token='.$_GET['token']);
            return;
        }
          
		$data = [
		    "title"             => "Pengaturan Akun / Ubah Akun : ".(isset($pegawaiMeta->nama) ? $pegawaiMeta->nama : $pegawai->nama_pegawai),
			"page"				=> "pengaturanakun",
			"no_hp"             => isset($pegawaiMeta->no_hp) ? $pegawaiMeta->no_hp : $pegawai->no_hp,
			"is_admin"          => true,
		];
		
		$this->load->view('template/default', $data);
        return;

    }

    private function accessable($roles){
        if(!in_array($this->session->userdata('role_id'), $roles)){
            redirect('home?token='.$_GET['token']);
            exit();
        }
    }
}
