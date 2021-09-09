<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3>
        </div>
    <form method="post">                   
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?=base_url('user?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                <button class="btn btn-sm btn-success"><em class="ti-save"></em> Simpan</button>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-md-12">
                        <?php $no = 0;foreach($websites as $website): ?>
                        <?php if($website->jenis_auth=='default') : ?>
                        <div class="row">
                            <div class="col-md-2">
                                <?=$website->nama_website;?>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                <?php $roles = $this->db
                                                    ->where('website_id', $website->id)
                                                    ->get('tb_role')
                                                    ->result();
                                      $is_in = $this->db
                                                    ->where('user_id', $user->id)
                                                    ->where('website_id', $website->id)
                                                    ->where('jenis_pegawai', 'pegawai')
                                                    ->get('tb_user_roled_website')
                                                    ->num_rows();?>
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                <label class="mr-3 btn btn-sm" for="role_in_<?=$website->id."_0";?>">
                                    <input type="radio" id="role_in_<?=$website->id."_0";?>" name="role_in[<?=$website->id;?>]" value="0" <?=$is_in==0 ? "checked" : null ;?>>
                                    Tidak Ada Akses
                                </label> 
                                </div>
                                <?php foreach($roles as $role):?>
                                <?php $is_in = $this->db
                                                    ->where('user_id', $user->id)
                                                    ->where('website_id', $website->id)
                                                    ->where('role_id', $role->role_id)
                                                    ->where('jenis_pegawai', 'pegawai')
                                                    ->get('tb_user_roled_website')
                                                    ->num_rows();
                                ?>
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                <label class="mr-3 btn btn-sm" for="role_in_<?=$website->id."_".$role->role_id;?>">
                                    <input type="radio" id="role_in_<?=$website->id."_".$role->role_id;?>" name="role_in[<?=$website->id;?>]" value="<?=$role->role_id;?>" <?=$is_in>0 ? "checked" : null ;?>>    
                                    <?=$role->role_name;?>
                                </label> 
                                </div>
                                <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <?php else:?>

                        <div class="row">
                            <div class="col-md-2">
                                <?=$website->nama_website;?>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                <?php 
                                    $this->load->model('Api_model');
                                    $roles = $this->Api_model->role_api($website->id, 'get');
                                ?>
                                <?php if(!$roles): ?>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                    Tidak terhubung 
                                    
                                    </div>
                                <?php else: ?>
                                    <?php $is_in = $this->db
                                                        ->where('user_id', $user->id)
                                                        ->where('website_id', $website->id)
                                                        ->where('jenis_pegawai', 'pegawai')
                                                        ->get('tb_user_roled_website')
                                                        ->num_rows();
                                    ?>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                    <label class="mr-3 btn btn-sm" for="role_in_<?=$website->id."_0";?>">
                                        <input type="radio" id="role_in_<?=$website->id."_0";?>" name="role_in[<?=$website->id;?>]" value="0" <?=$is_in==0 ? "checked" : null ;?>>
                                        Tidak Ada Akses
                                    </label> 
                                    </div>
                                    <?php foreach($roles['data'] as $role):?>
                                    <?php $is_in = $this->db
                                                        ->where('user_id', $user->id)
                                                        ->where('website_id', $website->id)
                                                        ->where('role_id', $role['role_id'])
                                                        ->where('jenis_pegawai', 'pegawai')
                                                        ->get('tb_user_roled_website')
                                                        ->num_rows();
                                    ?>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                    <label class="mr-3 btn btn-sm" for="role_in_<?=$website->id."_".$role['role_id'];?>">
                                        <input type="radio" id="role_in_<?=$website->id."_".$role['role_id'];?>" name="role_in[<?=$website->id;?>]" value="<?=$role['role_id'];?>" <?=$is_in>0 ? "checked" : null ;?>>    
                                        <?=$role['role_name'];?>
                                    </label> 
                                    </div>

                                    <?php endforeach;?>
                                <?php endif;?>
                                </div>

                            </div>
                        </div>
                        
                        <?php endif;?>
                        <hr class="mb-4">
                        <?php $no++;endforeach; ?>
                </div>

            </li>
        </ul>
    </form>
    
    </div>
</div>

<?php $this->view('template/javascript'); ?>
            
      