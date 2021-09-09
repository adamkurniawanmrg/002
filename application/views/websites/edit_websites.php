<div class="content-wrapper">
    <div class="card">
          
        <div class="card-header">
              <h3>Edit Websites</h3>
        </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="<?=base_url('websites?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                </li>
            
                <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
                <li class="list-group-item">
                
                        <input type="hidden" name="id" value="<?= $editwebsite['id'] ?>">
                      
                    <div class="form-group col-12">
                      <label for="nama_website">Nama Website</label>
                      <input type="text" class="form-control" id="nama_website" placeholder="Masukan Nama Website" name="nama_website" value="<?= $editwebsite['nama_website'] ?>" >
                      <?= form_error('nama_website', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group col-12">
                      <label for="domain">Domain</label>
                      <input type="text" class="form-control" id="domain" placeholder="Masukan Nama Website" name="domain"  value="<?= $editwebsite['domain'] ?>" >
                      <?= form_error('domain', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                   
                    <div class="form-group col-12">
                      <label>Logo</label> <br>
                      <img src="<?= base_url("assets/images/logo_website/") . $editwebsite['logo'] ?>" class="img-thumbnail mb-2" alt="" width="100px">
                      <br>
                      <input type="file" name="logo" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    
                    
                </li>
                <li class="list-group-item">
                    <div class="col-12">
                        <input type="checkbox" id="is_hide_in_portal" name="is_hide_in_portal" value="1" <?=$editwebsite['is_hide_in_portal']==1 ? "checked" :null;?>>
                        <label for="is_hide_in_portal">Sembunyikan di halaman portal E-gov ?</label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-sm btn-primary mr-2"><em class="ti-save"></em> Simpan</button>
                    </div>
                </li>
                
                </form>
            </ul>
    </div>
</div>
            
<?php $this->view('template/javascript'); ?>
      