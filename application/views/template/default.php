<?php
    $ci = get_instance();
    $ci->load->model('Menu_model');
    $menu = $ci->Menu_model->getmenu();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?=base_url();?>" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=isset($title) ? $title : "Layanan E-Government";?></title>

  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  
  

<!-- Select 2-->
<link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/select2/select2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/select2-bootstrap-theme/select2-bootstrap.min.css">


<!--DAte picker-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />

  <!-- Plugin css for this page -->
  <?php 
    if(isset($css)){ 
      for($i=0; $i<count($css); $i++){
  ?>
    <link rel="stylesheet" href="<?=$css[$i];?>">
  <?php }} ?>
  <!-- End plugin css for this page -->

<style>
    <?=isset($cssCode) ? $cssCode : null;?>

    .iframe_homepopup{
        width: 100%;
        height: 500px;
    }

    .select2-container--bootstrap .select2-results__option[aria-selected=true] {
        background-color: #f5f5f5;
        color: #262626;
        display: none;
    }
    .table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td {
        padding: 0.65rem 0.9375rem;
    }
    .horizontal-menu .bottom-navbar .page-navigation > .nav-item.active > .nav-link .menu-title, .horizontal-menu .bottom-navbar .page-navigation > .nav-item.active > .nav-link .menu-arrow {
        color: #7b7575;
    }
    .horizontal-menu .bottom-navbar .page-navigation > .nav-item .submenu ul li a.active {
        color: #7b7575;
    }
    .labura-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 1%;
        padding-bottom: 1%;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }
    
    .labura-modal-content {
        margin: auto;
        width: 80%;
    }
    
    .labura-modal-close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    
    
    
    .card-modal {
        height: 700px;
    }

</style>
</head>

<body>
  <div class="container-scroller">
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="">
              <img src="assets/images/logolabura.png" alt="logo"/>
              <span>LAYANAN E-GOV</span>
            </a>
            <a class="navbar-brand brand-logo-mini" href="">
              <img src="assets/images/logolabura.png" alt="logo"/>
              <span>LAYANAN E-GOV</span>
            </a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-2">
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <!--<li class="nav-item dropdown mr-1">-->
              <!--  <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">-->
              <!--    <i class="ti-email mx-0"></i>-->
              <!--  </a>-->
              <!--  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">-->
              <!--    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--          <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">-->
              <!--      </div>-->
              <!--      <div class="preview-item-content flex-grow">-->
              <!--        <h6 class="preview-subject ellipsis font-weight-normal">David Grey-->
              <!--        </h6>-->
              <!--        <p class="font-weight-light small-text text-muted mb-0">-->
              <!--          The meeting is cancelled-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--          <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">-->
              <!--      </div>-->
              <!--      <div class="preview-item-content flex-grow">-->
              <!--        <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook-->
              <!--        </h6>-->
              <!--        <p class="font-weight-light small-text text-muted mb-0">-->
              <!--          New product launch-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--          <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">-->
              <!--      </div>-->
              <!--      <div class="preview-item-content flex-grow">-->
              <!--        <h6 class="preview-subject ellipsis font-weight-normal"> Johnson-->
              <!--        </h6>-->
              <!--        <p class="font-weight-light small-text text-muted mb-0">-->
              <!--          Upcoming board meeting-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--  </div>-->
              <!--</li>-->
              <!--<li class="nav-item dropdown">-->
              <!--  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">-->
              <!--    <i class="ti-bell mx-0"></i>-->
              <!--    <span class="count"></span>-->
              <!--  </a>-->
              <!--  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">-->
              <!--    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--        <div class="preview-icon bg-success">-->
              <!--          <i class="ti-info-alt mx-0"></i>-->
              <!--        </div>-->
              <!--      </div>-->
              <!--      <div class="preview-item-content">-->
              <!--        <h6 class="preview-subject font-weight-normal">Application Error</h6>-->
              <!--        <p class="font-weight-light small-text mb-0 text-muted">-->
              <!--          Just now-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--        <div class="preview-icon bg-warning">-->
              <!--          <i class="ti-settings mx-0"></i>-->
              <!--        </div>-->
              <!--      </div>-->
              <!--      <div class="preview-item-content">-->
              <!--        <h6 class="preview-subject font-weight-normal">Settings</h6>-->
              <!--        <p class="font-weight-light small-text mb-0 text-muted">-->
              <!--          Private message-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--    <a class="dropdown-item preview-item">-->
              <!--      <div class="preview-thumbnail">-->
              <!--        <div class="preview-icon bg-info">-->
              <!--          <i class="ti-user mx-0"></i>-->
              <!--        </div>-->
              <!--      </div>-->
              <!--      <div class="preview-item-content">-->
              <!--        <h6 class="preview-subject font-weight-normal">New user registration</h6>-->
              <!--        <p class="font-weight-light small-text mb-0 text-muted">-->
              <!--          2 days ago-->
              <!--        </p>-->
              <!--      </div>-->
              <!--    </a>-->
              <!--  </div>-->
              <!--</li>-->
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                    <h3 class="ti-user" style="margin-top: 5px; font-size: 25px;"></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item" href="javascript:;" style="background: #eaeaea;border-top: 5px solid #558B2F;cursor: default">
                    <i class="ti-user text-primary" style="color: #fff; font-weight: 700"></i>
                    <h4><?=$this->session->userdata('nama');?><br>
                    <small><?=$this->session->userdata('nama_opd');?></small></h4>
                  </a>
                  <a class="dropdown-item" href="<?=base_url('auth/pengaturanakun?token='.$_GET['token']);?>">
                    <i class="ti-settings text-primary"></i>
                    Pengaturan Akun
                  </a>
                  <a class="dropdown-item" href="<?=base_url('auth/logout');?>">
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
      <nav class="bottom-navbar">
        <div class="container">
            <?=$menu;?>
        </div>
      </nav>
    </div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">

        <?php $this->load->view($page);?>

        <footer class="container footer">
          <div class="w-100 clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?=date("Y");?> <a href="https://diskominfo.labura.go.id" target="_blank">DISKOMINFO</a>. All rights reserved.</span>
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
