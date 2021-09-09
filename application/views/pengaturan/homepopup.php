<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?= $title ?></h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?=$this->session->flashdata('pesan');?>
                  <form method="post" enctype="multipart/form-data">
                    <div class="form-group col-12">
                      <label for="judul">Judul</label>
                      <input type="text" class="form-control" id="judul" name="judul" value="<?=set_value('tipe') ? set_value('tipe') : (isset($homepopup->judul) ? $homepopup->judul:null);?>" placeholder="Masukkan Judul">
                      <?= form_error('judul', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="form-group col-12">
                      <label for="tipe">Tipe</label>
                      <select class="form-control" name="tipe" id="tipe">
                          <option value="embed" <?=set_value('tipe')=="embed" ? 'selected' : (isset($homepopup->tipe) && $homepopup->tipe=='embed' ? 'selected':null);?>>Embed</option>
                          <option value="image" <?=set_value('tipe')=="image" ? 'selected' : (isset($homepopup->tipe) && $homepopup->tipe=='image' ? 'selected':null);?>>Image</option>
                      </select>
                      <?= form_error('tipe', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="form-group col-12" id="bodyEmbed" style="display:none">
                      <label for="embed">Embed</label>
                      <textarea class="form-control" name="embed" id="embed"><?=isset($homepopup->konten) && $homepopup->tipe=='embed' ? $homepopup->konten : null;?></textarea>
                      <?= form_error('embed', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?=isset($homepopup->konten) && $homepopup->tipe=='embed' ? $homepopup->konten : null;?>
                    </div>
                    <div class="form-group col-12" id="bodyImage" style="display:none">
                      <label for="image">Upload Image</label><br>
                      <input type="file" name="image" id="image">
                      <?= form_error('image', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?=isset($homepopup->konten) && $homepopup->tipe=='image' ? "<img src='".base_url($homepopup->konten)."' width='100%'>" : null;?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tampilkan pada halaman utama ?</label><br>
                        <div class="row">
                            <div class="col-6">
                              <input type="radio" name="tampilkan" value="Ya" id="ya" <?=set_value('tampilkan')=="Ya" ? 'checked' : (isset($homepopup->tampilkan) && $homepopup->tampilkan=='Ya' ? 'checked':null);?>>
                              <label for="ya">Ya</label>
                            </div>
                            <div class="col-6">
                              <input type="radio" name="tampilkan" value="Tidak" id="tidak" <?=set_value('tampilkan')=="Tidak" ? 'checked' : (isset($homepopup->tampilkan) && $homepopup->tampilkan=='Tidak' ? 'checked':null);?>>
                              <label for="tidak">Tidak</label>
                            </div>
                        </div>
                      <?= form_error('tampilkan', '<small class="text-danger pl-2">', '</small>'); ?>
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
    changeBody()
    $('#tipe').change(function(){
        changeBody()
    })
    function changeBody(){
        if($('#tipe').val()=='image'){
            $('#bodyEmbed').hide()
            $('#bodyImage').show()
        }else if($('#tipe').val()=='embed'){
            $('#bodyEmbed').show()
            $('#bodyImage').hide()
        }
    }
</script>