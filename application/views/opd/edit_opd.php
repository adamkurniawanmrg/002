<div class="content-wrapper">
    <div class="card">
          
        <div class="card-header">
              <h3>Edit Opd</h3>
        </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="<?=base_url('opd?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                </li>
            
                <li class="list-group-item">
                
                  <form class="forms-sample" action="" method="post">
                        <input type="hidden" name="id" value="<?= $editopd['id'] ?>">
                      
                    <div class="form-group col-12">
                      <label for="nama_opd">Nama Opd</label>
                      <input type="text" class="form-control" id="nama_opd" placeholder="Masukan Nama Opd" name="nama_opd" value="<?= $editopd['nama_opd'] ?>" >
                      <?= form_error('nama_opd', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group col-12">
                      <label for="singkatan">Singkatan</label>
                      <input type="text" class="form-control" id="singkatan" placeholder="Masukan Singkatan Opd" name="singkatan"  value="<?= $editopd['singkatan'] ?>" >
                      <?= form_error('singkatan', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    
                   
                    
                    
                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-sm btn-primary mr-2">Update</button>
                    </div>
                  </form>
                  
                </li>
            </ul>
    </div>
</div>

<?php $this->view('template/javascript'); ?>
            
      