<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
          <h3>Edit Users</h3>
        </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="<?=base_url('user?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                </li>
                <li class="list-group-item">
                    <form class="forms-sample" action="" method="post">
                        <input type="hidden" name="id" value="<?= $edituser['id'] ?>">
                          
                        <div class="form-group col-12">
                          <label for="nama">Nama User</label>
                          <input type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="nama" value="<?= $edituser['nama'] ?> " >
                          <?= form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group col-12">
                          <label for="nama">OPD</label>
                          <select class="select2 form-control" name="opd_id">
                              <option value="">-- Pilih OPD --</option>
                              <?php foreach($opd as $opd):?>
                              <option value="<?=$opd->id;?>"><?=$opd->nama_opd;?></option>
                              <?php endforeach;?>
                          </select>
                          <?= form_error('opd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group col-12">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" placeholder="Masukan Username" name="username"  value="<?= $edituser['username'] ?> " >
                          <?= form_error('domain', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group col-12">
                          <label for="password">Password</label>
                          <input type="text" class="form-control" id="password" placeholder="Kosongkan bila tidak ingin mengganti Password" name="password" >
                          <?= form_error('password', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                       
                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-sm btn-primary mr-2">Simpan</button>
                        </div>
                    </form>
                </li>
            </ul>
    </div>
</div>
            
      
<?php $this->view('template/javascript'); ?>