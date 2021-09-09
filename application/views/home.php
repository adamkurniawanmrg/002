<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Layanan E-Gov Kab.Labuhanbatu Utara</h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
               <div class="row">
                   <div class="col-md-12">
                       Hai <strong><?=$this->session->userdata('nama');?></strong>. Selamat Datang di E-Gov Kab. Labuhanbatu Utara
                   </div>
               </div>
            </li>
        </ul>
    </div>


    <?php 
        $tampilkan = false;
        if(isset($homepopup) && $homepopup && $homepopup->tampilkan=='Ya'):
            $tampilkan = true;
    ?>
      <div class="modal fade" id="homeModal">
        <div class="modal-dialog modal-lg" role="document">
          <div class="container modal-content" style="padding:0;border:0">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?=$homepopup->judul;?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="padding: 0">
                <?=isset($homepopup->konten) && $homepopup->tipe=='image' ? "<img src='".base_url($homepopup->konten)."' width='100%'>" : null;?>            
                <?=isset($homepopup->konten) && $homepopup->tipe=='embed' ? $homepopup->konten : null;?>            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Ends -->
    <?php endif;?>

    <?=$this->session->flashdata('pesan');?>
    <div class="row" style="padding:0px 13px;margin-top:-1px">
		<?php $no = 1;
        foreach ($website as $bk) : 
        if(!$bk['role_id']){ continue;}
        ?>
		<div class="col-4 col-md-4 col-lg-2 mt-0 mb-0  grid-margin stretch-card mt-2" style="padding:0px 3px;">
			<div class="card">
				<a href="<?=base_url('redirect/getauthenticate/'.$bk['id'].'?token='.$_GET['token']);?>" style="color: #000;">
				    <div class="card-body text-center">
						<img src="<?= base_url("assets/images/logo_website/") . $bk['logo'] ?>" style="width: 100%" alt="logowebsite"/> 
				    </div>
				    <p style="font-size: 16px;text-align: center;" class="pb-1 text-center"><?= $bk['nama_website']; ?></p>
				</a>
			</div>
		</div>
        <?php endforeach;?>
    </div>

</div>
<?php $this->view('template/javascript');?>
<script>
    <?php if($tampilkan) : ?>
    $('#homeModal').modal('show');
    <?php endif;?>
</script>