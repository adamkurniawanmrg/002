<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{
    var $table = 'tb_pegawai'; //nama tabel dari database
    // var $table_pegawai = 'tb_pegawai'; //nama tabel dari database
    var $column_order = array(
        null, 'nama', 'nip', 'golongan', 'opd_id', 'jabatan_opd', 'jabatan_perbub_tpp', 'kepala', 'st_post', 'post_date', 'plt', 'kategori_pegawai', 'no_rekening', 'bendahara_opd', 'mesin_id'
    ); //field yang ada di table user

    var $column_search = array('nip', 'nama'); //field yang diizin untuk pencarian 
    var $order = array('id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Data Absen
    private function _get_datatables_query()
    {
        $this->db->select('tb_pegawai.*, tb_opd.nama_opd, tb_jabatan_golongan.nama_golongan');
        $this->db->from('tb_pegawai');
        $this->db->join('tb_opd', 'tb_pegawai.opd_id = tb_opd.id');
        $this->db->join('tb_jabatan_golongan', 'tb_pegawai.golongan = tb_jabatan_golongan.id');

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->db->select('tb_pegawai.*, tb_opd.nama_opd, tb_mesin.nama_mesin, tb_jabatan_penghasilan.nama_jabatan, tb_jabatan_golongan.nama_golongan');
        $this->db->from('tb_pegawai');
        $this->db->join('tb_opd', 'tb_opd.id = tb_pegawai.opd_id', 'left');
        $this->db->join('tb_mesin', 'tb_mesin.id = tb_pegawai.mesin_id', 'left');
        $this->db->join('tb_jabatan_penghasilan', 'tb_jabatan_penghasilan.id = tb_pegawai.jabatan_perbub_tpp', 'left');
        $this->db->join('tb_jabatan_golongan', 'tb_jabatan_golongan.id = tb_pegawai.golongan', 'left');
        return $this->db->get()->result_array();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        // $this->db->from('p_item');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function getPegawai()
    {
        return $this->db->get('tb_pegawai')->row_array();
    }

    public function getAllPegawai()
    {
        return $this->db->get('tb_pegawai')->result_array();
    }

    public function getPegawaiById($id)
    {
        return $this->db->get_where('tb_pegawai', ['id' => $id])->row_array();
    }

    // function get_datatables()
    // {
    //     $this->db->select('tb_pegawai.*, tb_opd.nama_opd, tb_mesin.nama_mesin, tb_jabatan_penghasilan.nama_jabatan, tb_jabatan_golongan.nama_golongan');
    //     $this->db->from('tb_pegawai');
    //     $this->db->join('tb_opd', 'tb_opd.id = tb_pegawai.opd_id', 'left');
    //     $this->db->join('tb_mesin', 'tb_mesin.id = tb_pegawai.mesin_id', 'left');
    //     $this->db->join('tb_jabatan_penghasilan', 'tb_jabatan_penghasilan.id = tb_pegawai.jabatan_perbub_tpp', 'left');
    //     $this->db->join('tb_jabatan_golongan', 'tb_jabatan_golongan.id = tb_pegawai.golongan', 'left');
    //     return $this->db->get()->result_array();
    // }

    public function getPegawaiByOpd()
    {
        return $this->db->get('tb_pegawai')->result();
    }



    public function getPegawaiSenamMeta($senam_id)
    {
        $this->db->select('tb_absen_senam_meta.*, tb_pegawai.id pegawai_id, tb_pegawai.nama, tb_pegawai.nip');
        $this->db->from('tb_absen_senam_meta');
        $this->db->where('absen_senam_id', $senam_id);
        $this->db->join('tb_pegawai', 'tb_pegawai.id = tb_absen_senam_meta.pegawai_id', 'left');
        return $this->db->get()->result();
    }
    public function getPegawaiUpacaraMeta()
    {
        $this->db->select('tb_absen_upacara_meta.*, tb_pegawai.id pegawai_id, tb_pegawai.nama, tb_pegawai.nip');
        $this->db->from('tb_absen_upacara_meta');
        $this->db->join('tb_pegawai', 'tb_pegawai.id = tb_absen_upacara_meta.pegawai_id', 'left');
        return $this->db->get()->result();
    }

    public function addDataPegawai()
    {
        $jabatan_rangkap_perbub = $this->input->post('plt', true) == 1 ? $this->input->post('jabatan_rangkap_perbub', true) : null;
        if ($this->input->post('kategori_pegawai', true) == 1) {
            $data = [
                "nama"                   => $this->input->post('nama', true),
                "opd_id"                 => $this->input->post('opd_id', true),
                "jabatan_opd"            => "",
                "jabatan_perbub_tpp"     => 0,
                "kepala"                 => 0,
                "st_post"                => $this->input->post('status_upload', true),
                "post_date"              => date("Y-m-d H:i:s"),
                "kategori_pegawai"       => "tks",
                "no_rekening"            => 0,
                "mesin_id"               => $this->input->post('mesin_id', true),
            ];
        } else if ($this->input->post('kategori_pegawai', true) == 2) {
            $data = [
                "nama"                   => $this->input->post('nama', true),
                "nip"                    => $this->input->post('nip', true),
                "golongan"               => $this->input->post('golongan', true),
                "opd_id"                 => $this->input->post('opd_id', true),
                "jabatan_opd"            => $this->input->post('jabatan_opd', true),
                "jabatan_perbub_tpp"     => $this->input->post('jabatan_perbub_tpp', true),
                "st_post"                => $this->input->post('status_upload', true),
                "post_date"              => date("Y-m-d H:i:s"),
                "cpns"                   => $this->input->post('cpns', true),
                "plt"                    => $this->input->post('plt', true),
                "jabatan_rangkap_perbub" => $jabatan_rangkap_perbub,
                "kategori_pegawai"       => "pegawai",
                "no_rekening"            => 0,
                "kepala"                 => $this->input->post('kepala', true),
                "bendahara_opd"          => $this->input->post('operator_opd', true),
                "mesin_id"               => $this->input->post('mesin_id', true),
            ];
        }
        $this->db->insert('tb_pegawai', $data);
    }

    public function editDataPegawai($id)
    {
        $jabatan_rangkap_perbub = $this->input->post('plt', true) == 1 ? $this->input->post('jabatan_rangkap_perbub', true) : null;
        if ($this->input->post('kategori_pegawai', true) == 1) {
            $data = [
                "nama"                   => $this->input->post('nama', true),
                "opd_id"                 => $this->input->post('opd_id', true),
                "jabatan_opd"            => "",
                "jabatan_perbub_tpp"     => 0,
                "kepala"                 => 0,
                "st_post"                => $this->input->post('status_upload', true),
                "post_date"              => date("Y-m-d H:i:s"),
                "kategori_pegawai"       => "tks",
                "no_rekening"                 => 0,
                "mesin_id"               => $this->input->post('mesin_id', true),
            ];
        } else if ($this->input->post('kategori_pegawai', true) == 2) {
            $data = [
                "nama"                   => $this->input->post('nama', true),
                "nip"                    => $this->input->post('nip', true),
                "golongan"               => $this->input->post('golongan', true),
                "opd_id"                 => $this->input->post('opd_id', true),
                "jabatan_opd"            => $this->input->post('jabatan_opd', true),
                "jabatan_perbub_tpp"     => $this->input->post('jabatan_perbub_tpp', true),
                "st_post"                => $this->input->post('status_upload', true),
                "post_date"              => date("Y-m-d H:i:s"),
                "cpns"                   => $this->input->post('cpns', true),
                "plt"                    => $this->input->post('plt', true),
                "jabatan_rangkap_perbub" => $jabatan_rangkap_perbub,
                "kategori_pegawai"       => "pegawai",
                "no_rekening"            => 0,
                "kepala"                 => $this->input->post('kepala_opd', true),
                "bendahara_opd"           => $this->input->post('operator_opd', true),
                "mesin_id"               => $this->input->post('mesin_id', true),
            ];
        }
        $this->db->where('id', $id);
        $this->db->update('tb_pegawai', $data);
    }

    public function deleteDataPegawai($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_pegawai');
    }
}
