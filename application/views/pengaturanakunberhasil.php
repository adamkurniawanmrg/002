<div class="content-wrapper">
    <!-- Page Heading -->
    <div class="card">
        <div class="card-header">
            <span class="h5 mb-4 text-gray-800"><?= $title ?></span>
        </div>
        <ul class="list-group list-group-flush">
            <center>
                <li class="list-group-item">
                    <img src="/assets/img/icon/ceklis.png" width="150px">
                    <div class="mt-2 mb-2"><b class="mt-3 mb-3">Akun Berhasil Diubah!</b></div>
                    <a href="<?=base_url('/home?token='.$_GET['token'])?>" class="btn btn-success">Kembali</a>
                </li>    
            </center>
        </ul>
    </div>
</div>

<?php $this->view('template/javascript'); ?>