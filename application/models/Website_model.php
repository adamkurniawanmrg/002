<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Website_model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set("Asia/Jakarta");
   }
   public function getAllWebsite()
   {
      return $this->db->get('tb_websites')->result_array();
   }

   public function getWebsiteById($id)
   {
      return $this->db->get_where('tb_websites', ['id' => $id])->row_array();
   }


   public function addData()
   {

      $data = [
         "nama_website"      => $this->input->post('nama_website', true),
         "domain"            => $this->input->post('domain', true),
         "logo"             => $this->_upload(),
       
         "created_at"       => date("Y-m-d H:i:s"),
      ];
      // print_r($data);
      $this->db->where('id', $this->input->post('id'));
      $this->db->insert('tb_websites', $data);
   }


   public function editData()
   {
      if ($_FILES["logo"]["name"] != "") {
         $upload = $this->_upload($this->input->post('logo', true));
         // if ($upload[0] == false) {
         //    return $upload;
         // }

         $data = [
         "nama_website"      => $this->input->post('nama_website', true),
         "domain"            => $this->input->post('domain', true),
         "logo"             => $this->_upload(),
       
         "created_at"       => date("Y-m-d H:i:s"),

         ];

         $this->_deleteImage($this->input->post('id'));
      } else {
         $data = [
         "nama_website"      => $this->input->post('nama_website', true),
         "domain"            => $this->input->post('domain', true),
       
       
         "created_at"       => date("Y-m-d H:i:s"),
         ];
      }
    
      $data["is_hide_in_portal"] = isset($_POST['is_hide_in_portal']) ? $_POST['is_hide_in_portal'] : null;
      // print_r($data);
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('tb_websites', $data);
   }

   public function deleteData($id)
   {
    //   $this->_deleteImage($id);
      $this->db->where('id', $id);
      $this->db->delete('tb_websites');
   }

   private function _deleteImage($id)
   {
      $produk = $this->getWebsiteById($id);
      
       if($produk['logo'] == null ){
            return;
        }

      $filename = $produk['logo'];
      array_map('unlink', glob(FCPATH . "assets/images/logo_website/$filename"));
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
