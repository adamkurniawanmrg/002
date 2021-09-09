<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set("Asia/Jakarta");
   }

   public function getAllUser($skpd_id=false)
   {
        $SIMPEG      = $this->load->database('otherdb', TRUE);

        if($skpd_id){
            $SIMPEG->where('pegawai.id_skpd', $skpd_id);
        }else{
            if($this->session->userdata('role_id')!=1){
                $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
                if(count($unitkerjas)>0){
                    foreach($unitkerjas as $unitkerja){
                        $SIMPEG->or_where('pegawai.id_skpd', $unitkerja->skpd_id);                
                    }
                }else{
                    $SIMPEG->where('pegawai.id_skpd', $this->session->userdata('skpd_id'));                
                }
            }
        }
        
        $pegawai       = $SIMPEG->select('  pegawai.id_pegawai pegawai_id,
                                            pegawai.nama_pegawai, 
                                            pegawai.gelar_depan,
                                            pegawai.gelar_belakang,
                                            pegawai.nip,
                                            pegawai.no_hp,
                                            pegawai.id_skpd opd_id,
                                            skpd.nama_skpd
                                            ')
                                ->where('status_pegawai', 'pegawai')
                                ->where('nama_pegawai!=','')
                                ->where('nip!=','')
                                ->where('nama_pegawai is NOT NULL')
                                ->where('nip is NOT NULL')
                                ->join('skpd', 'skpd.id_skpd=pegawai.id_skpd', 'left')
                                ->order_by('nama_pegawai')
                                ->get('pegawai')->result();

        return $pegawai;
   }
   
   public function getUserByOpd($opd_id)
   {
        $SIMPEG      = $this->load->database('otherdb', TRUE);

        $pegawai       = $SIMPEG->select('  pegawai.id_pegawai pegawai_id,
                                            pegawai.nama_pegawai, 
                                            pegawai.nip,
                                            pegawai.no_hp,
                                            pegawai.id_skpd opd_id,
                                            skpd.nama_skpd
                                            ')
                                ->where('id_skpd', $opd_id)
                                ->where('status_pegawai', 'pegawai')
                                ->where('nama_pegawai!=','')
                                ->where('nip!=','')
                                ->where('nama_pegawai is NOT NULL')
                                ->where('nip is NOT NULL')
                                ->join('skpd', 'skpd.id_skpd=pegawai.id_skpd', 'left')
                                ->order_by('nama_pegawai')
                                ->get('pegawai')->result();

        return $pegawai;
   }

   public function getUserById($id)
   {
        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $pegawai       = $SIMPEG->select('  pegawai.id_pegawai pegawai_id,
                                            pegawai.nama_pegawai, 
                                            pegawai.nip,
                                            pegawai.no_hp,
                                            pegawai.id_skpd opd_id,
                                            skpd.nama_skpd
                                            ')
                                ->where('id_pegawai', $id)
                                ->join('skpd', 'skpd.id_skpd=pegawai.id_skpd', 'left')
                                ->get('pegawai')->row();
        
        return $pegawai;
   }


   public function addData()
   {

      $data = [
         "nama"                => $this->input->post('nama', true),
         "opd_id"               => $this->input->post('opd_id', true),
         "username"            => $this->input->post('username', true),
         "password"            => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
         "is_active"           => 1,
         "created_at"          => date("Y-m-d H:i:s"),
      ];
      // print_r($data);
      $this->db->where('id', $this->input->post('id'));
      $this->db->insert('tb_users', $data);
   }


   public function editData()
   {
      if ($_POST["password"] != "") {
        
         $data = [
         "opd_id"               => $this->input->post('opd_id', true),
          "nama"                => $this->input->post('nama', true),
         "username"            => $this->input->post('username', true),
         "password"            => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
         "is_active"           => 1,
         "created_at"          => date("Y-m-d H:i:s"),

         ];

        
      } else {
         $data = [
         "opd_id"               => $this->input->post('opd_id', true),
         "nama"                => $this->input->post('nama', true),
         "username"            => $this->input->post('username', true),
         "is_active"           => 1,
         "created_at"          => date("Y-m-d H:i:s"),
         ];
      }


      $this->db->where('id', $this->input->post('id'));
      $this->db->update('tb_users', $data);
   }

   public function deleteData($id)
   {
    //   $this->_deleteImage($id);
      $this->db->where('id', $id);
      $this->db->delete('tb_users');
   }


   private function _upload()
   {

      $this->_createdPHP('./assets/images/logo_website/');

      $config['upload_path']          = './assets/images/logo_website/';
      $config['allowed_types']        = 'jpg|png|jpeg';
      $config['overwrite']            = true;
      $config['max_size']             = 2024; // 2MB
      // $config['encrypt_name']         = true;
      // $config['file_name']            = md5(time());
      // $config['max_width']            = 1024;
      // $config['max_height']           = 768;

    //   $new_name = $this->input->post('judul', true);
    //   $namafile = preg_replace("/[^a-zA-Z0-9]/", "-", $new_name);
    //   $config['file_name'] = $namafile;

      $this->load->library('upload', $config);


      if ($this->upload->do_upload('logo')) {
         return $this->upload->data('file_name');
      } else {
         $error = array('error' => $this->upload->display_errors());
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
