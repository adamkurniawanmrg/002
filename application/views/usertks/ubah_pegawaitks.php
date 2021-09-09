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
                
              <form class="forms-sample" action="" method="post">
                  <input type="hidden" name="id" value="<?= $edittks['id'] ?>">
                  
                <div class="form-group col-12">
                  <label for="nik">NIK TKS</label>
                  <input type="number" class="form-control" id="nik" placeholder="Masukan NIK" name="nik" value="<?= $edittks['nik'] ?>">
                  <?= form_error('nik', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Nama TKS</label>
                  <input type="text" class="form-control" id="nama_tks" placeholder="Masukan Nama" name="nama_tks" value="<?= $edittks['nama_tks'] ?>">
                  <?= form_error('nama_tks', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Unit Kerja</label>
                  <select class="select2 form-control" name="skpd_id">
                      <option value="">-- Pilih Unit Kerja --</option>
                      <?php foreach($skpsd as $opd):?>
                        <option value="<?=$opd->id_skpd?>" <?= $edittks['skpd_id'] == $opd->id_skpd ? "selected" : null ?> ><?=$opd->nama_skpd  ?></option>
                           <!--<option value="<?= $o['id']; ?>" <?= $editpegawai['opd_id'] == $o['id'] ? "selected" : null ?>><?= $o['nama_opd']; ?></option>-->
                      <?php endforeach;?>
                  </select>
                  <?= form_error('opd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>

                
                <div class="form-group col-12">
                  <label for="no_hp">No Hp</label>
                  <input type="number" class="form-control" id="no_hp" placeholder="Masukan No Hp" name="no_hp" value="<?= $edittks['no_hp'] ?>">
                  <?= form_error('no_hp', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Alamat</label>
                  <input type="text" class="form-control" id="alamat" placeholder="Masukan Alamat" name="alamat" value="<?= $edittks['alamat'] ?>">
                  <?= form_error('alamat', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir" placeholder="Masukan Tempat Lahir" value="<?= $edittks['tempat_lahir'] ?>" name="tempat_lahir">
                  <?= form_error('tempat_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group col-12">
                  <label for="nama">Tanggal Lahir</label>
                  <input type="text" class="form-control date" id="tanggal_lahir" placeholder="Masukan Tanggal Lahir" value="<?= date('d-m-Y',strtotime($edittks['tanggal_lahir'])) ?>" name="tanggal_lahir" autocomplete="off">
                  <?= form_error('tanggal_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                  <div class="form-group col-12">
                   <label for="jenkel">Jenis Kelamin</label>
                   <select id="jenkel" name="jenkel" class="form-control select2 col-12">
                      <option value="">Pilih Jenis Kelamin</option>
                      <?= $sptId['opd_id'] == $o['id_skpd'] ? "selected" : null ?>
                      
                         <option value="P" <?= $edittks['jenkel'] == "P" ? "selected" : null ?> >Pria</option>
                         <option value="W" <?= $edittks['jenkel'] == "W" ? "selected" : null ?> >Wanita</option>
                     
                   </select>
                </div>

                
                <div class="form-group col-12">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Kosongkan bila tidak ingin mengubah password" name="password">
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
      
      <script>
 $(document).ready(function() {
  $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
         })
 });
</script>
      