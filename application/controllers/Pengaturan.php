<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		is_logged_in();
    }

    public function index(){
        return false;
    }
    
    public function homepopup(){

        $homepopup = $this->db->get('tb_pengaturan_popup')->row();
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
		if ($this->form_validation->run()) {
            extract($_POST);
            if($_POST['tipe']=="image"){
                $upload = $this->_upload();
                $konten = $upload ? $upload : $homepopup->konten;
            }else if($_POST['tipe']=="embed"){
                $konten = $embed;
            }
            
            $data = [
                        "judul"     => $judul,
                        "tipe"      => $tipe,
                        "konten"    => $konten,
                        "tampilkan" => $tampilkan,
            ];
            
            if($homepopup){
                $this->db->where('id', $homepopup->id)->update('tb_pengaturan_popup', $data);
            }else{
                $this->db->insert('tb_pengaturan_popup', $data);            
            }
            
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil diset!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('pengaturan/homepopup?token=' . $_GET['token']);
		    return;
		}

		$this->load->view('template/default', [
		    "title"             => "Pengaturan Home Popup",
		    "popup"             => $this->db->order_by('id', 'asc')->get('tb_pengaturan_popup')->result_array(),
			"page"				=> "pengaturan/homepopup",
			"homepopup"         => $homepopup
		]);
        return;
		
    }
    
   private function _upload()
   {

      $this->_createdPHP('./assets/images/homepopup/');

      $config['upload_path']          = './assets/images/homepopup/';
      $config['allowed_types']        = 'jpg|png|jpeg|mp4';
      $config['overwrite']            = true;
      $config['max_size']             = 20240; // 2MB

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('image')) {
         return "assets/images/homepopup/".$this->upload->data('file_name');
      } else {
         return false;
      }

   
   }

   public function _createdPHP($DIR)
   {
      $index = fopen($DIR . "/index.php", "w") or die("Unable to open file!");
      $val = "<script>location.href='" . base_url() . "auth/blocked'</script>";
      fwrite($index, $val);
      fclose($index);
   }
    
    
}
