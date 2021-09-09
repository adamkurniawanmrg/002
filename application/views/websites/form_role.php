<div class="content-wrapper">
    <div class="card">
          
        <div class="card-header">
              <h3>Tambah Role - <?=$website->nama_website;?></h3>
        </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="<?=base_url('websites/role/'.$website->id.'?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                </li>
                <form method="post">
                <li class="list-group-item">
                    <div class="form-group col-12">
                      <label for="role_name">Nama Role</label>
                      <input type="text" class="form-control" id="role_name" placeholder="Masukan Nama Role" value="<?=isset($role) && $role ? $role['role_name'] : set_value('role_name');?>" name="role_name">
                      <?= form_error('role_name', '<small class="text-danger pl-2">', '</small>'); ?>
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
            
      