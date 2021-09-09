<div class="content-wrapper">
    <div class="card">
          <div class="card-header">
              <h3><?= $title ?></h3>
            </div>
           
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?=base_url('usertks?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
            </li>
            <form class="forms-sample" method="post">
            <li class="list-group-item">
                <?=$this->session->flashdata('pesan');?>
                <div class="form-group">
                  <label for="nik">NIK TKS</label>
                  <input type="number" class="form-control" id="nik" placeholder="Masukan NIK" name="nik" value="<?= $datatks->nik ?>" disabled>
                  <?= form_error('nik', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group">
                  <label for="nama">Nama TKS</label>
                  <input type="text" class="form-control" id="nama_tks" placeholder="Masukan Nama" name="nama_tks" value="<?= $datatks->nama_tks ?>" disabled>
                  <?= form_error('nama_tks', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                
                <div class="form-group">
                  <label for="nama">Unit Kerja</label>
                  <select class="select2 form-control" name="skpd_id" disabled>
                      <option value="">-- Pilih Unit Kerja --</option>
                      <?php foreach($skpsd as $opd):?>
                        <option value="<?=$opd->id_skpd?>" <?= $datatks->skpd_id == $opd->id_skpd ? "selected" : null ?> ><?=$opd->nama_skpd  ?></option>
                      <?php endforeach;?>
                  </select>
                  <?= form_error('opd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                </li>
                
                <li class="list-group-item">
                    <div class="form-group">
                        <label for="skpd_atasan_id">Unit Kerja Pegawai Atasan <span class="text-danger">*</span></label>
                        <select id="skpd_atasan_id" name="skpd_atasan_id" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Unit Kerja --</option>
                            <?php foreach ($gskpd as $o) : ?>
                                <option value="<?= $o['id_skpd']; ?>" <?= isset($pegawai_atasan->skpd_atasan_id) && $pegawai_atasan->skpd_atasan_id==$o['id_skpd'] ? "selected" : null ?>><?= $o['nama_skpd']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('opd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="pegawai_atasan_id">Pegawai Atasan <span class="text-danger">*</span></label>
                        <select id="pegawai_atasan_id" name="pegawai_atasan_id" class="form-control select2">
                            <option value="">-- Pilih Pegawai Atasan --</option>
                        </select>
                        <?= form_error('pegawai_atasan_id', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div>
                        <?=$pegawai_atasan  ? "<span class='text-primary'>Last updated on ".date("l, d F Y - H:i", strtotime($pegawai_atasan->updated_at))."<br>Set by ".$pegawai_atasan->set_by_nama_pegawai."</span>" : null;?>
                    </div>
                </li>
                <li class="list-group-item">
                    <button type="submit" class="btn btn-sm btn-primary"><em class="ti-save"></em> Selesai</button>
                </li>

            </form>
        </ul>
    </div>
</div>
         
<?php $this->view('template/javascript'); ?>   
<script>
$(document).ready(function() {
    getPegawaiAtasan();
    
    $('#skpd_atasan_id').change(function(){
        getPegawaiAtasan();
    });
    
    function getPegawaiAtasan(){
        $('#pegawai_atasan_id').find('option').remove().end();
        var skpd_id = $("#skpd_atasan_id").val();
        var pegawai_atasan_id = "<?=isset($pegawai_atasan->pegawai_atasan_id) ? $pegawai_atasan->pegawai_atasan_id."-_-".$pegawai_atasan->jenis_pegawai_atasan."-_-".$pegawai_atasan->nama_pegawai_atasan : 0;?>";
        $.ajax({
            type: "post",
            url: "<?= base_url() . '/usertks/selectOptionPegawaiAtasan?token=' . $_GET['token']; ?>",
            data: {
                skpd_id:skpd_id
            },
            success: function(data) {
                $("#pegawai_atasan_id").html(data);
                var a = $("#pegawai_atasan_id option[value='"+pegawai_atasan_id+"']").length > 0;
                if(a){
                    $("#pegawai_atasan_id").val(pegawai_atasan_id).change();
                }
            }
        });
    }

});
</script>
      