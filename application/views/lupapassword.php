<!DOCTYPE html>
<html lang="en">
<head>
    <!-- End Google Tag Manager -->
    <base href="<?=base_url();?>">
    <title><?=isset($title) ? $title : "Layanan E-Gov Labura";?></title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta charset="UTF-8">
     <meta name="description" content="Layanan Electronic Government (E-Gov) Kabupaten Labuhanbatu Utara (Labura)">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/assets_login/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets_login/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets_login/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <!--<link rel="shortcut icon" href="assets/assets_login/img/favicon.ico" type="image/x-icon" >-->
    <!--<link rel="shortcut icon" href="assets/images/logolabura.png" />-->
    <link rel="shortcut icon" href="assets/assets_login/img/logo-layanan.png" />

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/assets_login/css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="assets/assets_login/css/skins/default.css">
    
    <style>
    
    
    .login-18 .login-box-9 {
        /*margin: 0 80px 0 0;*/
        border-radius: 10px;
        opacity: 3;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 1.2);
        background-size: cover;
        background: rgba(0, 0, 0, 0.04) url('./assets/assets_login/img/bg5.jpg') top left repeat;
        background-size: cover;
        justify-content: center;
        align-items: center;
        position: relative;
        display: flex;
    }
    
    .login-18 .bg-img::before {
        opacity: 0.2;
        content: "";
        display: block;
        left: 0;
        right: 0;
        top: 0;
        background: rgba(0,0,0,9) top left repeat;
        border-radius: 10px;
        bottom: 0;
        height: 100%;
        width: 100%;
        position: absolute;
    }
    
    
    @media (min-width: 525px) {
    .logo-mini{
        display: none;
        
    }

    </style>


</head>
<body id="">

<!-- Login 18 start -->
<div class="login-18">
    <div class="container">
        <div class="col-md-12 pad-0">
            <div class="row login-box-9">
                <div class="col-lg-6 col-sm-12 col-pad-0 align-self-center" style="margin-top: 30px;" >
                    <div class="login-inner-form">
                        <div class="details">
                            <div class="logo-mini">
                                 <img src="assets/assets_login/img/logo-layanan.png" class="mb-2" alt="logo" width="200px">
                                <h3 class="mb-2">Layanan E-Government</h3>
                                <h3 class="text-white">Kabupaten Labuhanbatu Utara</h3>
                            </div>
                            <?= $this->session->flashdata('pesan'); ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                     <input type="text" class="form-control form-control-lg" name="username" id="username" value="<?= set_value('username');?>" placeholder="NIP / NIK">
                                      <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme btn-block">Lupa Password</button>
                                </div>
                            </form>
                                <div class="mb-3">
                                    <a href="<?=base_url();?>" class="text-white">Kembali</a>
                                </div>
                            <!--<p>Don't have an account?<a href="#"> Register here</a></p>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-pad-0 bg-img align-self-center none-992" >
                    <div class="inner">
                    
                        <img src="assets/assets_login/img/logo-layanan.png" class="mb-2" alt="logo" width="200px">
                        <h3 class="mb-2">Layanan E-Government</h3>
                        <h3 class="text-white">Kabupaten Labuhanbatu Utara</h3>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 18 end -->

<!-- External JS libraries -->
<script src="assets/assets_login/js/jquery-2.2.0.min.js"></script>
<script src="assets/assets_login/js/popper.min.js"></script>
<script src="assets/assets_login/js/bootstrap.min.js"></script>
<!-- Custom JS Script -->
</body>
</html>
