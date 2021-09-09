<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3>
        </div>
        <div class="card-body">        
            <form method="post" enctype="multipart/form-data">
                <div class="form-group col-12">
                  <label for="nama_role">Nama Role</label>
                  <input type="text" class="form-control" id="nama_role" placeholder="Masukan Nama Role" name="nama_role" value="<?=isset($role->role_name) ? $role->role_name : null;?>" autofocus>
                  <?= form_error('nama_role', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-6">
                    <a href="<?= base_url('akseswebsites/konfigurasirole/'.$website->id.'?token=' . $_GET['token']) ?>" class="btn btn-sm btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-sm btn-primary mr-2">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->view('template/javascript'); ?>
      