<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardmenu_model extends CI_Model
{
    

    
    public function getMenu($website_id = null){
        $hasil = '<ul class="sTree2 dyKemisSortable" id="sTree2">';
        
            $menu = $this->db->where('website_id', $website_id)->where('parent_id', null)->order_by('urutan', 'asc')->get('tb_menu')->result();
            
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<li id="menu_'.$m->id.'">
                                    <div style="font-weight:700"><em class="'.$m->icon.'"></em> '.$m->nama_menu.' <small class="text-primary">'.$m->url.'
                                    <br>
                                    <a href="javascript:;" role="button" class="btn btn-success" onclick="ubahmenu('.$m->id.')">Ubah</a>
                                    <a href="javascript:;" role="button" class="btn btn-danger" onclick="deletemenu('.$m->id.')">Hapus</a>
                                    </small>
                                    </div>
                                    <ul>';
                    $hasil .= $this->menu($m->id);
                    $hasil .= '</ul></li>';
                    continue;
                }else{
                    $hasil .= '<li id="menu_'.$m->id.'">
                                        <div style="font-weight:700"><em class="'.$m->icon.'"></em> '.$m->nama_menu.' <small class="text-primary">'.$m->url.'
                                        <br>
                                        <a href="javascript:;" role="button" class="btn btn-success" onclick="ubahmenu('.$m->id.')">Ubah</a>
                                        <a href="javascript:;" role="button" class="btn btn-danger" onclick="deletemenu('.$m->id.')">Hapus</a>
                                        </small>
                                        </div>
                                </li>';
                }
            }
        $hasil .= "</ul>";
        return $hasil;
    }

    private function menu($parent_id){
            $menu = $this->db->where('parent_id', $parent_id)->order_by('urutan', 'asc')->get('tb_menu')->result();
            $hasil ="";
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<li id="menu_'.$m->id.'">
                                    <div style="font-weight:700"><em class="'.$m->icon.'"></em> '.$m->nama_menu.' <small class="text-primary">'.$m->url.'
                                    <br>
                                    <a href="javascript:;" role="button" class="btn btn-success" onclick="ubahmenu('.$m->id.')">Ubah</a>
                                    <a href="javascript:;" role="button" class="btn btn-danger" onclick="deletemenu('.$m->id.')">Hapus</a>
                                    </small>
                                    </div>
                                    <ul>';
                    $hasil .= $this->menu($m->id);
                    $hasil .= '</ul></li>';
                    continue;
                }else{
                    $hasil .= '<li id="menu_'.$m->id.'">
                                        <div style="font-weight:700"><em class="'.$m->icon.'"></em> '.$m->nama_menu.' <small class="text-primary">'.$m->url.'
                                        <br>
                                        <a href="javascript:;" role="button" class="btn btn-success" onclick="ubahmenu('.$m->id.')">Ubah</a>
                                        <a href="javascript:;" role="button" class="btn btn-danger" onclick="deletemenu('.$m->id.')">Hapus</a>
                                        </small>
                                        </div>
                                </li>';
                }
            }
        return $hasil;
    }
    

    
}
?>
