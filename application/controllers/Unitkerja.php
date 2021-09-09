<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unitkerja extends CI_Controller {
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		is_logged_in();
    }

    public function getOpd(){
        $SIMPEG      = $this->load->database('otherdb', TRUE);
        $opds        = $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result();
        $data        = array();
        $no          = 1;
        foreach ($opds as $opd) {
            $nama_skpd      = explode(" ", $opd->nama_skpd);
            if(
                $opd->nama_skpd=='Satuan Polisi Pamong Praja' ||
                $nama_skpd[0]=='Dinas' ||
                $nama_skpd[0]=='Badan' ||
                $nama_skpd[0]=='Sekretariat' ||
                $nama_skpd[0]=='Kecamatan' ||
                $nama_skpd[0]=='Inspektorat'
            ){}else{continue;}
            $skpds          = $this->db->where('opd_id', $opd->id_skpd)->order_by('nama_skpd', 'asc')->get('tb_unit_kerja')->result();
            $jml            = 0;
            $unitkerja      = '<button class="btn btn-outline-primary" style="padding: 8px" type="button" data-toggle="collapse" data-target="#collapseUnitKerja_'.$opd->id_skpd.'" aria-expanded="false" aria-controls="collapseUnitKerja_'.$opd->id_skpd.'">
                                Show/Hide ('.count($skpds).')
                            </button>
                            <div class="collapse" id="collapseUnitKerja_'.$opd->id_skpd.'">
                                <div class="card card-body" style="max-width: 500px;white-space: break-spaces;"><ol>';
            foreach($skpds as $skpd){
                $unitkerja  .= '<li>'.$skpd->nama_skpd.'</li>';
                $jml++;
            }
            $unitkerja .= '</ol></div></div>';
            
            if($jml<=0){
                $unitkerja = "Tidak ada unit kerja";
            }
            $dt      = array();
            $dt[]    = $no;$no++;
            $dt[]    = $opd->nama_skpd;
            $dt[]    = $unitkerja;
            $dt[]    = '<a href="'.base_url('unitkerja/delegasikanunitkerja/') . $opd->id_skpd . '?token=' . $_GET['token'].'" class="btn btn-info btn-sm" style="padding: 3px 7px"><em class="ti-exchange-vertical"></em> Pilih Unit Kerja</a>';
            $data[]  = $dt;
        }
        echo json_encode(["data"=> $data]);
        return;
    }

    public function index(){
        $SIMPEG      = $this->load->database('otherdb', TRUE);
		$data = [
			"page"				=> "unitkerja/dataunitkerja",
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
			],
			"css"               =>[
                base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"), 
			],
		];
		
		$this->load->view('template/default', $data);
    }
    
    public function delegasikanunitkerja($opd_id=false){
        $SIMPEG     = $this->load->database('otherdb', TRUE);
        $opd        = $SIMPEG->where('id_skpd', $opd_id)->get('skpd')->row();
        
        if(!$opd){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf</strong> Data tidak ditemukan !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('unitkerja?token=' . $_GET['token']);
            return;
        }

        $this->form_validation->set_rules('skpd_id[]', 'Unit Kerja', 'required');
		
		if ($this->form_validation->run()) {
            extract($_POST);
            $data = array();
            foreach($skpd_id as $skpd){
                $skpd = explode("_", $skpd);
                $data[] = [
                        "opd_id"        => $opd->id_skpd,
                        "nama_opd"      => $opd->nama_skpd,
                        "skpd_id"       => $skpd[0],
                        "nama_skpd"     => $skpd[1]
                    ];
            }
            $this->db->where('opd_id', $opd_id)->delete('tb_unit_kerja');
            $this->db->insert_batch('tb_unit_kerja', $data);
            
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> OPD berhasil di perbaharui !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('unitkerja?token=' . $_GET['token']);
		    return;
		}

		$this->load->view('template/default', [
		    "title"             => "Pilih Unit Kerja - ".$opd->nama_skpd,
		    "skpds"             => $SIMPEG->order_by('nama_skpd', 'asc')->get('skpd')->result_array(),
		    "unitkerjas"        => $this->db->where('opd_id', $opd_id)->get('tb_unit_kerja')->result_array(),
		    "gunitkerjas"       => $this->db->get('tb_unit_kerja')->result_array(),
			"page"				=> "unitkerja/tambahunitkerja",
		]);
        return;
		
    }
    
}
