<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3></h3> 
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?=$this->session->flashdata('pesan');?>
                <form method="post">
                    <input type="hidden" name="generate" value="1">
                    <div class="form-group">
                      <label for="userkey">Userkey</label>
                      <input type="text" class="form-control" id="userkey" name="userkey" placeholder="Generate Otomatis" value="<?=$api ? $api->user_key : null;?>" disabled>
                      <?= form_error('userkey', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="passkey">Passkey</label>
                      <input type="text" class="form-control" id="passkey" name="passkey" placeholder="Generate Otomatis" value="<?=$api ? $api->pass_key : null;?>" disabled>
                      <?= form_error('passkey', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    
                    <?php if(!$api){?>
                    <div class="form-group col-12">
                        <button class="btn btn-sm btn-warning"><em class="ti-reload"></em> Generate API</button>
                    </div>
                    <?php } ?>
                </form>    

            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-7">
                        <strong>Source Code - Get Role API</strong>
                    </div>
                    <div class="col-md-5 text-right">
                        <?php if($api && isset($api->file_get_role)):?>
                            <a href="websites/get_source_code_get_role/<?=$api->website_id?>?token=<?=$_GET['token'];?>" target="_blank" class="btn btn-primary" style="padding: 5px 10px;"><em class="ti-download"></em> Download</a>
                            <a href="websites/generate_source_code_get_role/<?=$api->website_id;?>?token=<?=$_GET['token'];?>" onclick="if(!confirm('Source Code yang lama akan kedaluarsa, Apakah anda yakin untuk generate ulang?')) return false;" class="btn btn-warning" style="padding: 5px 10px;"><em class="ti-reload"></em> Generate Ulang File</a>
                        <?php elseif($api): ?>
                            <a href="websites/generate_source_code_get_role/<?=$website->id;?>?token=<?=$_GET['token'];?>" class="btn btn-warning" style="padding: 5px 10px;"><em class="ti-reload"></em> Generate File</a>
                        <?php else: ?>
                            <button class="btn btn-warning" style="padding: 5px 10px;" disabled><em class="ti-reload"></em> Generate File</button>
                        <?php endif;?>
                    </div>
                </div>
                
            </li>
        </ul>
        
    </div>
</div>

<?php $this->view('template/javascript'); ?>

