<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?= $title ?></h3>
        </div>
                
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?=base_url('usertks?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
            </li>
            <li class="list-group-item">
                <?=$this->session->flashdata('pesan');?>
              <form id="formTKS" class="forms-sample" action="" method="post">
                  
                  
                <div class="form-group col-12">
                  <label for="nik">NIK TKS</label>
                  <input type="number" class="form-control disabledScroll" id="nik" placeholder="Masukan NIK" name="nik">
                  <?= form_error('nik', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Nama TKS</label>
                  <input type="text" class="form-control" id="nama_tks" placeholder="Masukan Nama" name="nama_tks">
                  <?= form_error('nama_tks', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Unit Kerja</label>
                  <select class="select2 form-control" name="skpd_id">
                      <option value="">-- Pilih Unit Kerja --</option>
                      <?php foreach($skpsd as $opd):?>
                      <option value="<?=$opd->id_skpd?>"><?=$opd->nama_skpd?></option>
                      <?php endforeach;?>
                  </select>
                  <?= form_error('skpd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>

            
                <div class="form-group col-12">
                  <label for="no_hp">No Hp</label>
                  <input type="number" class="form-control disabledScroll" id="no_hp" placeholder="Masukan No Hp" name="no_hp">
                  <?= form_error('no_hp', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Alamat</label>
                  <input type="text" class="form-control" id="alamat" placeholder="Masukan Alamat" name="alamat">
                  <?= form_error('alamat', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir" placeholder="Masukan Tempat Lahir" name="tempat_lahir">
                  <?= form_error('tempat_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="tanggal_lahir">Tanggal Lahir</label>
                  <input type="text" class="form-control date" id="tanggal_lahir" placeholder="Masukan Tanggal Lahir" name="tanggal_lahir" autocomplete="off">
                  <?= form_error('tanggal_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                  <div class="form-group col-12">
                           <label for="jenkel">Jenis Kelamin</label>
                           <select id="jenkel" name="jenkel" class="form-control select2 col-12">
                              <option value="">Pilih Jenis Kelamin</option>
                              
                                 <option value="P">Pria</option>
                                 <option value="W">Wanita</option>
                             
                           </select>
                        </div>

                
               
               
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    
                </div>
              </form>
            </li>
        </ul>
    </div>
</div>
         
<?php $this->view('template/javascript'); ?>   

<script>
$(document).ready(function() {
    $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
    })
    
    $('.disabledScroll').on('wheel.disableScroll', function (e) {
        e.preventDefault()
    })
    $('.disabledScroll').off('wheel.disableScroll')
    
    $('.disabledScroll').keydown(function (e) {  
        if (e.keyCode == 38) {  
            return false;  
        }      
        if (e.keyCode == 40) {  
            return false;  
        }
    })

});
</script>
      