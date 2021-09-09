<?php

function is_logged_in()
{
    $ci = &get_instance();

    if (!$ci->session->userdata('token')) { redirect('auth'); exit(); }

    if (!loginToken()) { redirect('auth/regetToken'); exit(); }

    $user_id        = $ci->session->userdata('user_id');
    $jenis_pegawai  = $ci->session->userdata('jenis_pegawai');

    $website_id     = 1;
    $role = $ci->db->select('tb_role.*')
                             ->where('tb_user_roled_website.website_id', $website_id)
                             ->where('tb_user_roled_website.user_id', $user_id)
                             ->where('tb_user_roled_website.jenis_pegawai', $jenis_pegawai)
                             ->join('tb_role', 'tb_role.role_id=tb_user_roled_website.role_id', 'left')
                             ->get('tb_user_roled_website')->row();
    
    if(!$role){
        redirect('auth/forcelogout');
        exit();
    }


    $menu           = $ci->db->get_where('tb_menu', ['url' => $ci->uri->segment(1), 'website_id'=>$website_id])->row();

    if(!$menu){
        exit();
    }

    $userAccess  = $ci->db->get_where('tb_role_access', [
        'role_id' => $role->role_id,
        'menu_id' => $menu->id
    ]);

    if ($userAccess->num_rows() < 1){ redirect('auth/blocked404'); exit();}

    $meta = $ci->db->
                 where('pegawai_id', $ci->session->userdata('user_id'))->
                 where('jenis_pegawai', $ci->session->userdata('jenis_pegawai'))->
                 get('tb_pegawai_meta')->
                 row();
    if(!$meta){
        $ci->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Demi keamanan akun, dimohonkan agar untuk mengubah password anda!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
        redirect('auth/pengaturanakun?token='.$_GET['token']);
        exit();
    }
    if(password_verify('123', $meta->password)){
        $ci->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Mohon ubah password anda, password baru tidak boleh sama dengan password default!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
        redirect('auth/pengaturanakun?token='.$_GET['token']);
        exit();
    }

}



function loginToken(){
    $ci =&get_instance();

    if(!isset($_GET['token'])) return false;

    $token = $ci->db->where('token', $_GET['token'])->get('tb_token')->row();

    if(!$token) return false;
    if($token->status!=1) return false;
    
    return $token;
}




