<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akseswebsites extends CI_Controller {
	public function __construct(){
        parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model(['Dashboardmenu_model']);
    }
    public function index(){
		$data = [
		    "title"             => "Akses Websites",
			"page"				=> "akseswebsites/datawebsites",
			"website"           => $this->db->where('jenis_auth', 'default')->get('tb_websites')->result(),
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),
				base_url("assets/vendors/bs-custom-file-input/bs-custom-file-input.min.js"),
				base_url("assets/js/file-upload.js"),

				base_url("assets/js/select2.js"),
			
			],
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
			"javascriptCode"	=> "
    			(function($) {
    				'use strict';
    				$(function() {
    				  $('#order-listing').DataTable();
    				  
    				});
    				
    				
    			})(jQuery);
			",
			"cssCode"			=> "",
		];
		
		$this->load->view('template/default', $data);
    }

    public function konfigurasirole($idweb){
        $roles                   = $this->db->where('website_id', $idweb)->get('tb_role');
        $website                 = $this->db->where('id', $idweb)->get('tb_websites')->row();
        
        if(!$website){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Data Websites tidak ditemukan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');

            redirect('akseswebsites?token='.$_GET['token']);
            return;
        }
        
		$data = [
		    "title"             => $website->nama_website." - Konfigurasi Role",
			"page"				=> "akseswebsites/konfigurasirole",
		    "website"           => $website,
			"roles"             => $roles->result(),
			"javascript"		=> [
				base_url("assets/vendors/datatables.net/jquery.dataTables.js"),
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"),

			],
			"css"				=> [
				base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"),
			],
			"javascriptCode"	=> "
    			(function($) {
    				  $('#order-listing').DataTable();
    			})(jQuery);
			",
		];
		
		$this->load->view('template/default', $data);
    }

    public function tambahrole($idweb){
        $website                 = $this->db->where('id', $idweb)->get('tb_websites')->row();
        
        if(!$website){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Data Websites tidak ditemukan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');

            redirect('akseswebsites?token='.$_GET['token']);
            return;
        }
        
        
        $this->form_validation->set_rules('nama_role', 'Nama Role', 'required');

        if ($this->form_validation->run()) {
            extract($_POST);
            $this->db->insert('tb_role', ['website_id'=>$website->id,'role_name'=>$nama_role]);
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil !</strong> Role berhasil ditambahkan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('akseswebsites/konfigurasirole/'.$website->id.'?token='.$_GET['token']);
            return;
        }		

		$data = [
		    "title"             => $website->nama_website." - Tambah Role Baru",
			"page"				=> "akseswebsites/formrole",
		    "website"           => $website,
		];

		$this->load->view('template/default', $data);
		return;
    }
    

    private function getmenu($role, $website_id){
        $hasil = '<tbody>';
        $menu = $this->db ->where('parent_id', null)
                        ->where('website_id', $website_id)
                        ->order_by('urutan', 'asc')
                        ->get('tb_menu')
                        ->result();
            $no=1;
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<tr>
                                <th scope="row">'.$no.'</th>
                                <td>'.$m->nama_menu.'</td>
                                <td>'.$m->url.'</td>
                                <td align="right">
                                    <input type="checkbox" name="menu_id[]" value="'.$m->id.'" id="menu_'.$m->id.'" '.$this->isMenuChecked($role->role_id, $m->id).'>
                                    <label for="menu_'.$m->id.'">Ya</label>
                                </td>
                            </tr>';
                    $hasil .= $this->menu($m->id, $role);
                    continue;
                }else{
                    $hasil .= '<tr>
                                <th scope="row">'.$no.'</th>
                                <td>'.$m->nama_menu.'</td>
                                <td>'.$m->url.'</td>
                                <td align="right">
                                    <input type="checkbox" name="menu_id[]" value="'.$m->id.'" id="menu_'.$m->id.'" '.$this->isMenuChecked($role->role_id, $m->id).'>
                                    <label for="menu_'.$m->id.'">Ya</label>
                                </td>
                            </tr>';
                }
                $no++;
            }
        $hasil .= "</tbody>";
        return $hasil;
    }
    
    private function menu($parent_id, $role){
            $menu = $this->db->where('parent_id', $parent_id)
                            ->order_by('urutan', 'asc')
                            ->get('tb_menu')->result();
            $hasil ="";
            $no = 1;
            foreach($menu as $m){
                $cekChild = $this->db->where('parent_id', $m->id)->get('tb_menu')->num_rows();
                if($cekChild>0){
                    $hasil .= '<tr>
                                <th></th>
                                <td>'.$no.'. '.$m->nama_menu.'</td>
                                <td>'.$m->url.'</td>
                                <td align="right">
                                    <input type="checkbox" name="menu_id[]" value="'.$m->id.'" id="menu_'.$m->id.'" '.$this->isMenuChecked($role->role_id, $m->id).'>
                                    <label for="menu_'.$m->id.'">Ya</label>
                                </td>
                            </tr>';
                    $hasil .= $this->menu($m->id, $role);
                    continue;
                }else{
                    $hasil .= '<tr>
                                <th></th>
                                <td>'.$no.'. '.$m->nama_menu.'</td>
                                <td>'.$m->url.'</td>
                                <td align="right">
                                    <input type="checkbox" name="menu_id[]" value="'.$m->id.'" id="menu_'.$m->id.'" '.$this->isMenuChecked($role->role_id, $m->id).'>
                                    <label for="menu_'.$m->id.'">Ya</label>
                                </td>
                            </tr>';
                }
                $no++;
            }
        return $hasil;
    }
    

    
    public function konfigurasiaksesrole($idrole){
        $role                   = $this->db->where('role_id', $idrole)->get('tb_role')->row();
        
        if(!$role){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Data Role tidak ditemukan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');

            redirect('akseswebsites?token='.$_GET['token']);
            return;
        }
        
        $website                = $this->db->where('id', $role->website_id)->get('tb_websites')->row();
        $menu                   = $this->db->where('website_id', $role->website_id)->get('tb_menu')->result();



        if (isset($_POST['menu_id'])) {
            
            extract($_POST);
            $this->db->where('role_id', $role->role_id)->delete('tb_role_access');
            for($no=0; $no<count($menu_id); $no++){
                $this->db->insert('tb_role_access', ['role_id'=>$role->role_id, 'menu_id'=>$menu_id[$no]]);
            }
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil !</strong> Role akses berhasil diperbaharui!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
        }		

		$data = [
		    "title"             => ($website ? $website->nama_website : "Undefined")." - Konfigurasi Akses Role '".$role->role_name."'",
			"page"				=> "akseswebsites/konfigurasiaksesrole",
		    "role"              => $role,
		    "menu"              => $this->getMenu($role, 1),
		    "website"           => $website,
		    "controller"        => $this,
		];

		$this->load->view('template/default', $data);
		return;
    }
    
    public function isMenuChecked($role_id, $menu_id){
        $access = $this->db->where('role_id', $role_id)->where('menu_id', $menu_id)->get('tb_role_access')->row();
        if($access){
            return "checked";
        }
        
        return null;
    }

    public function ubahrole($idrole){
        $role                   = $this->db->where('role_id', $idrole)->get('tb_role')->row();
        
        if(!$role){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Data Role tidak ditemukan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');

            redirect('akseswebsites?token='.$_GET['token']);
            return;
        }
        
        $website                = $this->db->where('id', $role->website_id)->get('tb_websites')->row();



        $this->form_validation->set_rules('nama_role', 'Nama Role', 'required');

        if ($this->form_validation->run()) {
            extract($_POST);
            $this->db->where('role_id', $idrole)->update('tb_role', ['role_name'=>$nama_role]);
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil !</strong> Role berhasil diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');
            redirect('akseswebsites/konfigurasirole/'.$website->id.'?token='.$_GET['token']);
            return;
        }		

		$data = [
		    "title"             => ($website ? $website->nama_website : "Undefined")." - Ubah Role",
			"page"				=> "akseswebsites/formrole",
		    "role"              => $role,
		    "website"           => $website,
		];

		$this->load->view('template/default', $data);
		return;
    }
    public function hapusrole($idrole){
        $role                   = $this->db->where('id', $idrole)->get('tb_role')->row();
        
        if(!$role){
             $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Data Role tidak ditemukan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               ');

            redirect('akseswebsites?token='.$_GET['token']);
            return;
        }

        $website                = $this->db->where('id', $role->website_id)->get('tb_websites')->row();

        $this->db->where('id', $idrole)->delete('tb_role');
         $this->session->set_flashdata('pesan', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Role "'.$role->nama_role.'" berhasil dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           ');
        redirect('akseswebsites/konfigurasirole/'.$website->id.'?token='.$_GET['token']);
        return;

    }

	public function konfigurasi($idweb)
	{	
		$website = $this->db->where('id', $idweb)->get('tb_websites')->row();

		$data = [
            'title'			    => $website->nama_website." - Konfigurasi Menu",
			"page"				=> "akseswebsites/konfigurasi",
			'menus'             => $this->Dashboardmenu_model->getMenu($idweb),
			'javascript'		=> [
									base_url('assets/vendors/jquery-sortable-lists/jquery-sortable-lists.js'),
									base_url('assets/vendors/jquery-sortable-lists/jquery-sortable-lists.min.js'),
									base_url('assets/vendors/jquery-sortable-lists/jquery-sortable-lists-mobile.js'),
									base_url('assets/vendors/jquery-sortable-lists/jquery-sortable-lists-mobile.min.js'),
									base_url('assets/vendors/jquery-validation/jquery.validate.min.js'),
									base_url('assets/vendors/jquery-toast-plugin/jquery.toast.min.js')
									
			],
			'css'               => [
									base_url('assets/vendors/jquery-toast-plugin/jquery.toast.min.css')
			    ],
			'javascriptCode'      => "
			    var idweb       = ".$idweb.";
			    var baseUrl     = '".base_url()."';
			    var baseToken   = '".$_GET['token']."';
                
                function btnSaveChange(text, disabled=false){
                    $('#btnAddMenu').html(text);
                    if(disabled){
                        $('#btnAddMenu').prop('disabled', true);
                    }else{
                        $('#btnAddMenu').removeAttr('disabled');
                    }
                }
                
                function toast(toast, color){
                    $.toast({ 
                      text : toast, 
                      showHideTransition : 'slide',  // It can be plain, fade or slide
                      bgColor : color,              // Background color for toast
                      textColor : '#fff',            // text color
                      allowToastClose : false,       // Show the close button or not
                      hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
                      stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                      textAlign : 'left',            // Alignment of text i.e. left, right, center
                      position : 'top-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    })
                }

                $.validator.setDefaults({
                    submitHandler: function () {
                        btnSaveChange('Tunggu sebentar . . .', true);
                        $.ajax({
                            type: 'POST',
                            url: baseUrl+'akseswebsites/addmenu?token='+baseToken,
                            data: {
                                'menu_id'       : $('#menu_id').val()==null ? '' : $('#menu_id').val(),
                                'nama_menu'     : $('#nama').val(),
                                'url'           : $('#url').val(),
                                'icon'           : $('#icon').val(),
                                'website_id'    : idweb

                            },
                            success: function(data) {
                                btnSaveChange('Selesai');
                

                                data = $.parseJSON(data);
                                var elem = '<li id=\"menu_'+data[1].id+'\"><div style=\"font-weight:700\">'+data[1].nama_menu+' <small class=\"text-primary\">'+data[1].url+'<br><a href=\"javascript:;\" class=\"btn btn-success\" onclick=\"ubahmenu('+data[1].id+')\">Ubah</a> <a href=\"javascript:;\" class=\"btn btn-danger\" onclick=\"deletemenu('+data[1].id+')\">Hapus</a></small></div></li>';
                                if(data[0]==1){
                                    $('#sTree2').append(elem);
                                    toast('Menu baru berhasil ditambahkan!', 'green');

                                }else{
                                    location.reload();
                                }
                                
                                $('#menu_id').val(null);
                                $('#nama').val(null);
                                $('#url').val(null)
                                $('#icon').val(null)
                                
                                hideForm();
                            }
                        });
                    }
                });
                
                
                $('#formMenu').validate({
                    rules: {
                        nama: {
                            required: true,
                        },
                        url: {
                            required: true,
                        },
                        icon: {
                            required: true,
                        },
                
                    },
                    messages: {
                        nama: {
                            required: \"Silahkan masukkan Nama Menu terlebih dahulu.\",
                        },
                        url: {
                            required: \"Silahkan masukkan Url Menu terlebih dahulu.\",
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
                
                function ubahmenu(id){
                    $.ajax({
                        type    : \"POST\",
                        url     : baseUrl+\"/akseswebsites/editmenu?token=\"+baseToken,
                        data    : {
                                    \"menu_id\": id,
                                },
                        success : function(data) {
                            data = $.parseJSON(data);
                
                            $('#menu_id').val(data.id);
                            $('#nama').val(data.nama_menu);
                            $('#url').val(data.url);
                            $('#icon').val(data.icon);
                

                            showForm();
                        }
                    });
                }
                
                function deletemenu(id){
                    if(!confirm('Apakah anda yakin untuk menghapus ?')){
                        return;
                    }
                    $.ajax({
                        type    : \"POST\",
                        url     : baseUrl+\"/akseswebsites/deletemenu?token=\"+baseToken,
                        data    : {
                                    \"id\": id,
                                },
                        success : function(data) {
                            data = $.parseJSON(data);
                            location.reload();
                            
                        }
                    });
                }
                
                
                
                
                $('#btnSimpan').on('click', function(){ 
                    $('#btnSimpan').html('Tunggu Sebentar . . .');
                    $('#btnSimpan').prop('disabled', true);
                    $.ajax({
                        type    : \"POST\",
                        url     : baseUrl+\"/akseswebsites/simpan_urutan?token=\"+baseToken,
                        data    : {
                                    \"data\": $('#sTree2').sortableListsToArray(),
                                },
                        success : function(data) {
                            $('#btnSimpan').html('Simpan');
                            $('#btnSimpan').removeAttr('disabled');
                            
                            toast('Sukses!', 'green');
                
                        }
                    });
                
                });
                
                $('#btnBatal').on('click', function(){
                    location.reload();
                });
                
                $('#btnMenuBaru').on('click', function(){   
                    showForm();
                });
                
                $('#btnBatalAdd').on('click', function(){
                    hideForm();
                });
                
                
                function showForm(){
                    $('#body_add_menu').show(); 
                    $('#btnMenuBaru').hide(); 
                }
                function hideForm(){
                    $('#body_add_menu').hide(); 
                    $('#btnMenuBaru').show(); 
                    $('#menu_id').val(null);
                    $('#nama').val(null);
                    $('#url').val(null)
                
                }

            	var options = {
                    listsCss        : {'background-color':'silver', 'border':'1px solid white','padding':'7px'},
            		placeholderCss  : {'background-color': '#ff8', 'padding':'7px'},
            		hintCss         : {'background-color':'#af3',},
                    currElCss       : {'background-color':'green', 'color':'#fff'},
                    hintWrapperCss  : {'background-color':'#fff'},
            		onDragStart: function(e, el)
                	{
                	    el.css('list-style-type','none');
                	    el.css('padding-left','50px');
                	},
            		onChange: function( cEl )
            		{
                	    cEl.css('padding-left','50px');
            			console.log( 'onChange' );
            		},
            		complete: function( cEl )
            		{
                	    cEl.css('padding-left','12px');
            			console.log( 'complete' );
            		},
        
            		opener: {
            			active: true,
            			as: 'html',  // if as is not set plugin uses background image
            			close: '<img src=\"'+baseUrl+'assets/vendors/jquery-sortable-lists/imgs/Remove2.png\">',  // or 'fa-minus c3'
            			open: '<img src=\"'+baseUrl+'assets/vendors/jquery-sortable-lists/imgs/Add2.png\">',  // or 'fa-plus'
            			openerCss: {
            				'display': 'inline-block',
            				// 'width': '18px', 'height': '18px',
            				'float': 'left',
            				'margin-left': '-35px',
            				'margin-right': '5px',
            				//'background-position': 'center center', 'background-repeat': 'no-repeat',
            				'font-size': '1.1em'
            			}
            		},
            		ignoreClass: 'clickable'
            	};
                $('#sTree2').sortableLists( options );
			",
			"cssCode"   => "
                .dyKemisSortable{
                    list-style-type:none;
                    margin:0;
                    padding:0;
                }
                .dyKemisSortable li:first-child{
                    margin: 5px;
                    border-top: 1px solid rgba(200,200,200,.2);
                }
                .dyKemisSortable li{
                    list-style-type:none;
                    margin: 5px;
                    padding: 12px;
                    background: #fff;
                    border: 1px solid rgba(200,200,200,.2);
                    border-left: 50px solid#f3f3f3;
                    border-bottom: 1px solid rgba(200,200,200,.2);
                    cursor: pointer;
                    border-radius: 3px;
                }
			"

		];
		$this->load->view('template/default', $data);

	}
	
	public function simpan_urutan(){

		if (!empty($_POST)) {
            extract($_POST);
            for($i=0; $i<count($data); $i++){
                $menu = $data[$i];
                $id          = $this->convert_id($menu['id']);
                $parent_id   = isset($menu['parentId']) ? $this->convert_id($menu['parentId']) : null;
                
                $this->db->where('id', $id)->update('tb_menu', ['parent_id'=>$parent_id, 'urutan'=>$menu['order']]);
            }
		}
	    
	}
	
	private function convert_id($last_id){
	    $last_id = explode("_", $last_id);
	    return $last_id[1];
	}
	
	public function addmenu(){

		if (!empty($_POST)) {
		    
		    $menu_id = $_POST['menu_id'];
		    unset($_POST['menu_id']);
			if($menu_id!=null){
				$this->db->where('id', $menu_id)->update('tb_menu', $_POST);				
				$menu = $this->db->where('id', $menu_id)->get('tb_menu')->row();				
				echo json_encode([2, $menu]);
				return;
			}
			$this->db->insert('tb_menu', $_POST);
			$menu = $this->db->where('id', $this->db->insert_id())->get('tb_menu')->row();				
			echo json_encode([1, $menu]);
			return;
		}
		echo json_encode(false);
		return;
	}

	public function editmenu(){
		if (!empty($_POST)) {
			extract($_POST);
			$data = $this->db->where('id', $menu_id)->get('tb_menu')->row();
			echo json_encode($data);
			return;			
		}
		echo json_encode(false);
		return;
	}
	public function deletemenu(){
		if (!empty($_POST)) {
			extract($_POST);
			$this->db->where('parent_id', $id)->update('tb_menu', ['parent_id'=>null]);
			$data = $this->db->where('id', $id)->delete('tb_menu');
			echo json_encode(true);
			return;			
		}
		echo json_encode(false);
		return;
	}
    
}
