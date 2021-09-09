<div class="content-wrapper">
    <div class="card">
              <div class="card-header">
                  <h3><?=$title;?></h3>
                </div>
                <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item">
                        <?=$this->session->flashdata('pesan');?>
        
                          <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">No WhatsApp Baru <span class="text-danger">*</span></label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                              <input type="number" class="form-control" name="no_hp" placeholder="Masukkan No.WA" value="<?=$no_hp?>">
                              <span class="form-text text-danger"><?php echo form_error('no_hp'); ?></span>
                              <i class="form-text text-secondary ml-1">Nomor Whatsapp harus dilengkapi. Jika tidak punya nomor Whatsapp, masukkan nomor telepon.</i>
                            </div>
                          </div>
                        
                    </li>
                    <li class="list-group-item">
                          <i class="form-text text-secondary mb-2">
                              <ul>
                                  <li>Kosongkan form dibawah ini jika tidak ingin mengubah password.</li>
                                  <li>(Rekomendasi) Ubah password anda jika belum pernah mengubah password default anda.</li>
                              </ul>
                          </i>
                          <?php if(!isset($is_admin)) :?>
                          <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Password Lama <span class="text-danger">*</span></label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                              <input type="text" class="form-control" name="password_lama" placeholder="Masukkan password lama">
                              <span class="form-text text-danger"><?php echo form_error('password_lama'); ?></span>
                            </div>
                          </div>
                          <?php endif;?>
                          
                          <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Password Baru <?php if(!isset($is_admin)) :?><sup class="text-danger">*, Minimal 6 karakter</sup><?php endif;?></label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                              <input type="text" class="form-control" name="password_baru" id="password_baru" placeholder="Masukkan Password Baru">
                              <span class="form-text text-danger"><?php echo form_error('password_baru'); ?></span>
                            </div>
                          </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">UPDATE PROFIL</button>
                        </div>

                    </li>
                </ul>

                </form>
        </div>
    </div>
    <?php $this->view('template/javascript');?>
    <script>
        $(document).ready(function(){
            $(document).scrollTop(0);
        });
    </script>

            
      