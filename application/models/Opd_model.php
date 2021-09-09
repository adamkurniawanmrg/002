<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opd_model extends CI_Model
{
    public function getAllOpd()
    {
        return $this->db->get('tb_opd')->result_array();
    }


    public function addDataOpd()
    {
        $data = [
            "nama_opd"          => $this->input->post('nama_opd', true),
            "singkatan"          => $this->input->post('singkatan', true),
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->insert('tb_opd', $data);
    }

    public function editDataOpd()
    {
        $data = [
            "nama_opd"          => $this->input->post('nama_opd', true),
            "singkatan"          => $this->input->post('singkatan', true),
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('tb_opd', $data);
    }

    public function getOpdById($id)
    {
        return $this->db->get_where('tb_opd', ['id' => $id])->row_array();
    }

    public function deleteDataOpd($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_opd');
    }
}
