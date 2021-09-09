<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    
    private function role(){
        $user_id        = $this->session->userdata('user_id');
        $jenis_pegawai  = $this->session->userdata('jenis_pegawai');
        $website_id     = 1;
        $role = $this->db->select('tb_role.*')
                                 ->where('tb_user_roled_website.website_id', $website_id)
                                 ->where('tb_user_roled_website.user_id', $user_id)
                                 ->where('tb_user_roled_website.jenis_pegawai', $jenis_pegawai)
                                 ->join('tb_role', 'tb_role.role_id=tb_user_roled_website.role_id', 'left')
                                 ->get('tb_user_roled_website')->row();
        return $role;

    }
    public function getmenu(){
        $website_id = 1;
        $role_id = $this->role()->role_id;
        $hasil = '<ul class="nav page-navigation">';
            $menu = $this->db->select('tb_role_access.*, tb_menu.*')
                            ->where('tb_role_access.role_id', $role_id)
                            ->where('tb_menu.website_id', $website_id)
                            ->where('tb_menu.parent_id', null)
                            ->join('tb_menu', 'tb_role_access.menu_id=tb_menu.id', 'left')
                            ->order_by('tb_menu.urutan', 'asc')
                            ->get('tb_role_access')->result();
    
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<li class="nav-item">
                                  <a href="#" class="nav-link" onclick="return false">
                                    <i class="'.$m->icon.' menu-icon"></i>
                                    <span class="menu-title">'.$m->nama_menu.'</span>
                                    <i class="menu-arrow"></i>
                                  </a>
                                  <div class="submenu">
                                    <ul class="submenu-item">
                                    ';
                                
                    $hasil .= $this->menu($m->id, $role_id);
                    $hasil .= '</ul></div></li>';
                    continue;
                }else{
                    $hasil .= '<li class="nav-item">
                                  <a class="nav-link" href="'.base_url($m->url."?token=".$_GET['token']).'">
                                    <i class="'.$m->icon.' menu-icon"></i>
                                    <span class="menu-title">'.$m->nama_menu.'</span>
                                  </a>
                                </li>';
                }
            }
        $hasil .= "</ul>";
        return $hasil;
    }
    
    public function menu($parent_id, $role_id){
            $menu = $this->db   ->select('tb_role_access.*, tb_menu.*')
                                ->where('tb_role_access.role_id', $role_id)
                                ->where('tb_menu.parent_id', $parent_id)
                                ->join('tb_menu', 'tb_role_access.menu_id=tb_menu.id', 'left')
                                ->order_by('tb_menu.urutan', 'asc')
                                ->get('tb_role_access')->result();
    
            $hasil ="";
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<li class="nav-item">
                                  <a href="#" class="nav-link" onclick="return false">
                                    <i class="'.$m->icon.' menu-icon"></i>
                                    <span class="menu-title">'.$m->nama_menu.'</span>
                                    <i class="menu-arrow"></i>
                                  </a>
                                  <div class="submenu">
                                    <ul class="submenu-item">
                                    ';
                                
                    $hasil .= $this->menu($m->id, $role_id);
                    $hasil .= '</ul></div></li>';
                    continue;
                }else{
                    $hasil .= '<li class="nav-item">
                                  <a class="nav-link" href="'.base_url($m->url."?token=".$_GET['token']).'">
                                    <i class="'.$m->icon.' menu-icon"></i>
                                    <span class="menu-title">'.$m->nama_menu.'</span>
                                  </a>
                                </li>';
                }
            }
        return $hasil;
    }
}