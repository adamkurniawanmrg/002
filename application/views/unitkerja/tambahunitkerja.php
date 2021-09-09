<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?= $title ?></h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                  <form method="post">
                    <div class="form-group col-12">
                      <label for="nama">Unit Kerja</label>
                      <select class="select2 form-control" name="skpd_id[]" multiple="multiple" style="padding: 10px">
                          <option value="">-- Pilih Unit Kerja --</option>
                          <?php 
                            $idSkpd = array();
                            foreach($unitkerjas as $unitkerja):
                            $idSkpd[]   = $unitkerja['skpd_id'];
                          ?>
                          <option value="<?=$unitkerja['skpd_id']."_".$unitkerja['nama_skpd'];?>" selected><?=$unitkerja['nama_skpd'];?></option>
                          <?php endforeach;?>
                          <?php 
                            foreach($gunitkerjas as $unitkerja):
                                $idSkpd[]   = $unitkerja['skpd_id'];
                            endforeach;
                          ?>
                          <?php 
                          foreach($skpds as $skpd):
                            if(in_array($skpd['id_skpd'], $idSkpd)){
                                continue;
                            }
                          ?>
                          <option value="<?=$skpd['id_skpd']."_".$skpd['nama_skpd']?>"><?=$skpd['nama_skpd'];?></option>
                          <?php endforeach;?>
                      </select>
                      <?= form_error('skpd_id[]', '<small class="text-danger pl-2">', '</small>'); ?>
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
      