<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawaitks_model extends CI_Model
{
    
     public function __construct()
   {
      parent::__construct();
      date_default_timezone_set("Asia/Jakarta");
   }
    
    
    public function getAllTks($skpd_id=false)
    {
		$SIMPEG      = $this->load->database('otherdb', TRUE);


        if($skpd_id){
            $SIMPEG->where('tb_pegawai_tks.skpd_id', $skpd_id);
        }else{
            if($this->session->userdata('role_id')!=1){
                $unitkerjas = $this->db->where('opd_id', $this->session->userdata('skpd_id'))->get('tb_unit_kerja')->result();
                if(count($unitkerjas)>0){
                    foreach($unitkerjas as $unitkerja){
                        $SIMPEG->or_where('tb_pegawai_tks.skpd_id', $unitkerja->skpd_id);                
                    }
                }else{
                    $SIMPEG->where('tb_pegawai_tks.skpd_id', $this->session->userdata('skpd_id'));                
                }
            }
        }
            
        

        return $SIMPEG->
                    select('tb_pegawai_tks.*, skpd.nama_skpd')->
                    join('skpd', 'skpd.id_skpd=tb_pegawai_tks.skpd_id', 'left')->
                    order_by('tb_pegawai_tks.id', 'desc')->
                    get('tb_pegawai_tks')->result();

    }


    public function addDataTks()
    {
		$SIMPEG      = $this->load->database('otherdb', TRUE);
        $data = [
            "skpd_id"        => $this->input->post('skpd_id', true),
            "nama_tks"       => $this->input->post('nama_tks', true),
            "nik"            => $this->input->post('nik', true),
            "no_hp"          => $this->input->post('no_hp', true),
            "password"       => password_hash(123, PASSWORD_DEFAULT),
            "tanggal_lahir"  => date("Y-m-d", strtotime($this->input->post('tanggal_lahir', true))),
            "tempat_lahir"   => $this->input->post('tempat_lahir', true),
            "jenkel"         => $this->input->post('jenkel', true),
            "alamat"         => $this->input->post('alamat', true),
            "created_at"     => date('yy-m-d H:i:s')
        ];
        $SIMPEG->insert('tb_pegawai_tks', $data);
        $user_id = $SIMPEG->insert_id();

        $access = [
                    0 => ["website_id"=>1,"role_id"=>5],
                    1 => ["website_id"=>2,"role_id"=>2],
                    2 =>["website_id"=>8,"role_id"=>4],
                    3 =>["website_id"=>9,"role_id"=>4],
                    4 =>["website_id"=>10,"role_id"=>3]
            ];
        foreach($access as $acc){
            $this->db->insert('tb_user_roled_website', [
                    "user_id"       => $user_id,
                    "role_id"       => $acc['role_id'],
                    "jenis_pegawai" => 'tks',
                    "website_id"    => $acc['website_id']
                ]);
        }

    }

    public function editDataTks($id)
    {
		$SIMPEG      = $this->load->database('otherdb', TRUE);
        $data = [
            "skpd_id"        => $this->input->post('skpd_id', true),
            "nama_tks"       => $this->input->post('nama_tks', true),
            "nik"            => $this->input->post('nik', true),
            "no_hp"          => $this->input->post('no_hp', true),
            "tanggal_lahir"  => date("Y-m-d", strtotime($this->input->post('tanggal_lahir', true))),
            "tempat_lahir"  => $this->input->post('tempat_lahir', true),
            "jenkel"  => $this->input->post('jenkel', true),
             "alamat"  => $this->input->post('alamat', true),
        ];
        if ($_POST["password"] && $_POST["password"] != "") {
            $data['password']       = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        
        $SIMPEG->where('id', $id)->update('tb_pegawai_tks', $data);

        $pegawaiMeta            = $this->db->
                                         where('pegawai_id', $id)->
                                         where('jenis_pegawai', 'tks')->
                                         get('tb_pegawai_meta')->
                                         row();
        $data = [
                'password'      => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'no_hp'         => $_POST['no_hp'],
                'nip'           => $_POST['nik'],
                'pegawai_id'    => $id,
                'jenis_pegawai' => 'tks',
            ];
    
        if($pegawaiMeta){
            $this->db->where('id', $pegawaiMeta->id)->update('tb_pegawai_meta', $data);
        }else{
            $this->db->insert('tb_pegawai_meta', $data);
        }

    }

    public function getTksById($id)
    {
		$SIMPEG      = $this->load->database('otherdb', TRUE);
        return $SIMPEG->get_where('tb_pegawai_tks', ['id' => $id])->row_array();
    }

    public function deleteDataTks($id)
    {
		$SIMPEG      = $this->load->database('otherdb', TRUE);
        $SIMPEG->where('id', $id)->delete('tb_pegawai_tks');
        $this->db->where('pegawai_id', $id)->where('jenis_pegawai', 'tks')->delete('tb_pegawai_meta');
    }
}
