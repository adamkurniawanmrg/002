<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensiopd extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
        $this->load->model(['Opd_model','Pegawai_model']);
    }

    public function index(){
        if(isset($_POST['referensi'])){
            foreach($_POST['referensi'] as $egov_opd=>$simpeg_opd):
                if(!$simpeg_opd){
                    continue;
                }
                if($this->db->where('egov_opd', $egov_opd)->get('referensi_opd')->row()){
                    $this->db->where('egov_opd', $egov_opd)->update('referensi_opd', ['simpeg_opd'=>$simpeg_opd]);
                    continue;
                }
                $this->db->insert('referensi_opd', ['egov_opd'=>$egov_opd, 'simpeg_opd'=>$simpeg_opd]);
            endforeach;
            return;
        }
        $SIMPEG      = $this->load->database('otherdb', TRUE);
		$opds        = $this->db->order_by('nama_opd', 'asc')->get('tb_opd')->result();
        $skpds       = $SIMPEG->order_by('nama_skpd')->get('skpd')->result();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <base href="http://newabsensi.egov.labura.go.id/" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Referensiopd</title>

  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  

    <!-- Select 2-->
    <link rel="stylesheet" href="http://newabsensi.egov.labura.go.id/assets/select2/css/select2.min.css">
    <link rel="stylesheet" href="http://newabsensi.egov.labura.go.id/assets/select2-bootstrap4-theme/select2-bootstrap4.min.css">

</head>

<body>
  <div class="container-scroller">
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="">
              <img src="assets/images/logolabura.png" alt="logo"/>
              <span><strong>ABSENSI</strong></span>
            </a>
            <a class="navbar-brand brand-logo-mini" href="">
              <img src="assets/images/logolabura.png" alt="logo"/>
            </a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-2">
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown mr-1">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                  <i class="ti-email mx-0"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                      <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                      </h6>
                      <p class="font-weight-light small-text text-muted mb-0">
                        The meeting is cancelled
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                      <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                      </h6>
                      <p class="font-weight-light small-text text-muted mb-0">
                        New product launch
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                      <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                      </h6>
                      <p class="font-weight-light small-text text-muted mb-0">
                        Upcoming board meeting
                      </p>
                    </div>
                  </a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="ti-bell mx-0"></i>
                  <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-success">
                        <i class="ti-info-alt mx-0"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-normal">Application Error</h6>
                      <p class="font-weight-light small-text mb-0 text-muted">
                        Just now
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-warning">
                        <i class="ti-settings mx-0"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-normal">Settings</h6>
                      <p class="font-weight-light small-text mb-0 text-muted">
                        Private message
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-info">
                        <i class="ti-user mx-0"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-normal">New user registration</h6>
                      <p class="font-weight-light small-text mb-0 text-muted">
                        2 days ago
                      </p>
                    </div>
                  </a>
                </div>
              </li>
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                    <h3 class="ti-user"></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item" href="javascript:;" style="background: #eaeaea;border-top: 5px solid #558B2F">
                    <i class="ti-user text-primary" style="color: #fff; font-weight: 700"></i>
                    <h4>Admin <br>
                    <small>Undefined</small></h4>
                  </a>
                  <a class="dropdown-item" href="http://newabsensi.egov.labura.go.id/auth/logout">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="ti-menu"></span>
            </button>
          </div>
        </div>
      </nav>

    </div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">

        <div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Referensi OPD</h3> 
        </div>
    </div>
    <hr>
         <div class="col-md-12 mt-3">
            <form action="<?=base_url('referensiopd');?>" method="post">
                <?php foreach($opds as $opd):?>
                <div class="row" style="padding">
                    <div class="col-md-4"><?=$opd->nama_opd;?></div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select name="referensi[<?=$opd->id;?>]" class="form-control select2">
                                <option value="">-- Pilih OPD --</option>
                                <?php foreach($skpds as $skpd):?>
                                <option value="<?=$skpd->id_skpd;?>" <?=$skpd->nama_skpd==$opd->nama_opd ? 'selected':null;?>><?=$skpd->nama_skpd;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <div class="row" style="padding">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm mb-3">Generate</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        
        
    </div>
</div>

<!-- inject:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/js/template.js"></script>
<!-- endinject -->


<!-- Select2 -->
<script src="http://newabsensi.egov.labura.go.id/assets/select2/js/select2.min.js"></script>

  
  
<script>
    $(document).ready(function() {
        
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    })
</script>

        <footer class="container footer">
          <div class="w-100 clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2021 <a href="https://diskominfo.labura.go.id" target="_blank">DISKOMINFO</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>

        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->




</body>

</html>




	
		
		
<?php		
    }
    
}
